<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\PickupScheduled;
use App\Mail\PickupConfirmation;
use Inertia\Inertia;

class PickupController extends Controller
{
    public function index()
    {
        $pickups = Pickup::with(['donation.user', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return inertia('Pickups/Index', [
            'pickups' => $pickups
        ]);
    }

    public function create()
    {
        $donationId = request('donation_id');
        $donation = Donation::with('user')->findOrFail($donationId);

        return inertia('Pickups/Create', [
            'donation' => $donation
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500'
        ]);

        $donation = Donation::with('user')->findOrFail($validated['donation_id']);
        
        // Vérifier si c'est un receiver et si la quantité dépasse 5
        if (auth()->user()->role === 'receiver' && $donation->quantity > 5) {
            return back()->withErrors([
                'quantity' => 'As a recipient, you can only collect donations of 5 portions maximum.'
            ]);
        }

        // Générer un token de confirmation unique
        $confirmationToken = Str::random(60);

        // Créer le pickup
        $pickup = Pickup::create([
            'donation_id' => $validated['donation_id'],
            'user_id' => auth()->id(),
            'scheduled_at' => $validated['scheduled_at'],
            'notes' => $validated['notes'],
            'status' => 'pending', // En attente de confirmation
            'confirmation_token' => $confirmationToken,
        ]);

        // Envoyer email au RECEVEUR (celui qui schedule le pickup)
        Mail::to(auth()->user()->email)->send(
            new PickupScheduled($pickup, $donation, auth()->user())
        );

        // Envoyer email au DONATEUR avec lien de confirmation
        Mail::to($donation->user->email)->send(
            new PickupConfirmation($pickup, $donation, auth()->user(), $confirmationToken)
        );

        return redirect()->route('pickups.index')
            ->with('success', 'Pickup scheduled successfully! The donor will receive a confirmation email.');
    }

    public function confirm($token)
{
    $pickup = Pickup::where('confirmation_token', $token)
        ->where('status', 'pending')
        ->with(['donation.user', 'user'])
        ->firstOrFail();

    $donation = $pickup->donation;

    $pickup->update([
        'status' => 'confirmed',
        'confirmed_at' => now(),
    ]);

    $donation->update([
        'status' => 'reserved',
    ]);
    //$donation->delete();

    // Envoyer un email au receveur pour confirmer
    Mail::to($pickup->user->email)->send(
        new \App\Mail\PickupConfirmed($pickup, $donation)
    );    

    return inertia('Pickups/Confirmed', [
        'pickup' => $pickup,
        'message' => 'Pickup confirmed successfully! The donation has been removed from the site.'
    ]);
}

    public function destroy(Pickup $pickup)
    {
        // Vérifier que c'est bien le propriétaire du pickup
        if ($pickup->user_id !== auth()->id()) {
            abort(403);
        }

        $pickup->delete();

        return redirect()->route('pickups')
            ->with('success', 'Pickup cancelled successfully.');
    }
}