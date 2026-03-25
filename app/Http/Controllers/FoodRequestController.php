<?php

namespace App\Http\Controllers;

use App\Models\FoodRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Donation;
use App\Models\FoodRequestDonation;
use App\Models\Partner;
use App\Notifications\OrganizationRequestSent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PartnershipRequestReceived;
use App\Models\PartnerRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\FoodOfferNotification;
use App\Mail\FoodOfferAccepted;
use App\Mail\FoodOfferRejected;
use App\Models\Contribution;


class FoodRequestController extends Controller
{
    public function index(Request $request)
{
    $orgId = $request->user()->id;

    $requests = FoodRequest::with(['foodRequestDonations', 'contributions.partner'])
        ->where('organization_id', $orgId)
        ->orderBy('created_at', 'desc')
        ->get(); // ou ->paginate(10) si tu veux la pagination

    return Inertia::render('FoodRequests/Index', [
        'requests' => $requests,
    ]);
}

public function send(Request $request)
{
    $request->validate([
        'partner_id' => 'required|exists:partners,id',
    ]);

    $partner = Partner::find($request->partner_id);
    $organization = auth()->user()->partner; // si partner = organization

    // Crée la demande (food request ou liaison directe selon ton modèle)
    $foodRequest = FoodRequest::create([
        'title' => 'New Request from ' . $organization->name,
        'description' => 'Automatic request sent to partner.',
        'organization_id' => $organization->id,
        'status' => 'pending',
    ]);

    // Notifie le partenaire
    $partner->user->notify(new \App\Notifications\FoodRequestReceived($foodRequest));

    return back()->with('success', 'Request sent to partner.');
}

public function sendPartnerRequest(Request $request)
{
    $request->validate([
        'partner_id' => 'required|exists:partners,id',
    ]);

    // Créer la demande de partenariat
    $partnerRequest = new PartnerRequest(); // Assure-toi que tu as ce modèle
    $partnerRequest->partner_id = $request->partner_id;
    $partnerRequest->user_id = auth()->user()->id; // L'utilisateur actuel qui envoie la demande
    $partnerRequest->status = 'pending'; // Par exemple, le statut initial
    $partnerRequest->save();

    // Envoi une notification si besoin
    $partner = Partner::find($request->partner_id);
    $partner->user->notify(new PartnerRequestReceived($partnerRequest));

    return response()->json(['message' => 'Request sent successfully!']);
}


public function sendRequestToPartner(Request $request)
{
    $partner = Partner::findOrFail($request->partner_id);
    $organization = auth()->user()->partner;

    // (Création de la requête ici...)

$partner->user->notify(new PartnershipRequestReceived($organization));

    return back()->with('success', 'Request sent to partner');
}

    public function publicIndex(Request $request)
{
    $requests = FoodRequest::where('needed_before', '>=', now())
        ->orderBy('needed_before', 'asc')
        ->get();

    return Inertia::render('FoodRequests/PublicIndex', [
        'requests' => $requests,
    ]);
}

    public function create()
    {
        return Inertia::render('FoodRequests/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string',
            'description'   => 'nullable|string',
            'quantity'      => 'nullable|integer|min:1',
            'target_amount' => 'nullable|numeric|min:0',
            'needed_before' => 'nullable|date|after:now',
            'paypal_link' => 'nullable|url',

        ]);

        $request->user()->foodRequests()->create($data);

        return redirect()->route('food-requests.index')
            ->with('success', 'Food request created.');
    }

    public function show(FoodRequest $foodRequest)
    {
        $foodRequest->load(['foodRequestDonations.user', 'contributions.partner']);
        return Inertia::render('FoodRequests/Show', [
            'request' => $foodRequest,
        ]);
    }

    public function respondToRequest(Request $request, FoodRequest $foodRequest)
{
    $data = $request->validate([
        'quantity' => 'required|integer|min:1',
        'available_until' => 'required|date|after:now',
    ]);

    FoodRequestDonation::create([
        'food_request_id' => $foodRequest->id,
        'user_id' => $request->user()->id,
        'quantity' => $data['quantity'],
        'unit' => 'servings',
        'available_until' => $data['available_until'],
    ]);

    return back()->with('success', 'Your donation has been recorded.');
}
public function destroy(FoodRequest $foodRequest)
{
    // Vérifie que l'utilisateur est bien le propriétaire
    if ($foodRequest->organization_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    $foodRequest->delete();

    return redirect()->route('food-requests.index')->with('success', 'Request deleted successfully.');
}/**
 * User offre de la nourriture (appelé depuis Show.vue)
 */
public function respond(Request $request, FoodRequest $foodRequest)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
        'available_until' => 'required|date|after:now',
    ]);

    $foodRequest->load('user');

    // Générer un token unique
    $confirmationToken = Str::random(60);

    // Créer l'offre avec status pending
    $foodOffer = FoodRequestDonation::create([
        'food_request_id' => $foodRequest->id,
        'donation_id' => null, // Pas lié à une donation existante
        'user_id' => auth()->id(),
        'quantity' => $validated['quantity'],
        'available_until' => $validated['available_until'],
        'status' => 'pending',
        'confirmation_token' => $confirmationToken,
    ]);

    // Envoyer email au PARTNER avec boutons Accept/Decline
    Mail::to($foodRequest->user->email)->send(
        new FoodOfferNotification($foodOffer, $foodRequest, auth()->user(), $confirmationToken)
    );

    return redirect()->back()->with('success', 'Your food offer has been sent! The partner will review it.');
}

/**
 * Formulaire pour accepter l'offre (le partner renseigne date, lieu, note)
 */
public function showAcceptForm($token)
{
    $foodOffer = FoodRequestDonation::where('confirmation_token', $token)
        ->where('status', 'pending')
        ->with(['foodRequest.user', 'user'])
        ->firstOrFail();

    return inertia('FoodRequests/AcceptOffer', [
        'foodOffer' => $foodOffer,
        'foodRequest' => $foodOffer->foodRequest,
    ]);
}

/**
 * Partner accepte l'offre et envoie date/lieu/note
 */
public function acceptOffer(Request $request, $token)
{
    $foodOffer = FoodRequestDonation::where('confirmation_token', $token)
        ->where('status', 'pending')
        ->with(['foodRequest.user', 'user'])
        ->firstOrFail();

    $validated = $request->validate([
        'scheduled_date' => 'required|date|after:now',
        'location' => 'required|string|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'partner_note' => 'nullable|string|max:500',
    ]);

    // Mettre à jour l'offre
    $foodOffer->update([
        'status' => 'accepted',
        'scheduled_date' => $validated['scheduled_date'],
        'location' => $validated['location'],
        'latitude' => $validated['latitude'] ?? null,
        'longitude' => $validated['longitude'] ?? null,
        'partner_note' => $validated['partner_note'] ?? null,
    ]);

    // Envoyer email au contributeur avec date, lieu, Google Maps
    Mail::to($foodOffer->user->email)->send(
        new FoodOfferAccepted($foodOffer, $foodOffer->foodRequest)
    );

    return redirect()->route('food-requests.manage-contributions')
        ->with('success', 'Offer accepted! The contributor has been notified with pickup details.');
}

/**
 * Partner refuse l'offre
 */
public function declineOffer($token)
{
    $foodOffer = FoodRequestDonation::where('confirmation_token', $token)
        ->where('status', 'pending')
        ->with(['foodRequest.user', 'user'])
        ->firstOrFail();

    // Mettre à jour le statut
    $foodOffer->update([
        'status' => 'rejected',
    ]);

    // Envoyer email au contributeur
    Mail::to($foodOffer->user->email)->send(
        new FoodOfferRejected($foodOffer, $foodOffer->foodRequest)
    );

    return redirect()->route('food-requests.manage-contributions')
        ->with('success', 'Offer declined. The contributor has been notified.');
}

/**
 * Page de gestion des contributions (pour le partner)
 */
public function manageContributions()
{
    $user = auth()->user();

    // Récupérer toutes les food requests du partner
    $foodRequests = FoodRequest::where('organization_id', $user->id)
        ->with([
            'foodRequestDonations.user',
            'contributions.partner'
        ])
        ->get();

    // Organiser les contributions par statut
    $pendingOffers = [];
    $acceptedOffers = [];
    $confirmedOffers = [];
    $pendingPaypal = [];
    $confirmedPaypal = [];

    foreach ($foodRequests as $request) {
        foreach ($request->foodRequestDonations as $offer) {
            if ($offer->status === 'pending') {
                $pendingOffers[] = $offer;
            } elseif ($offer->status === 'accepted') {
                $acceptedOffers[] = $offer;
            } elseif ($offer->status === 'confirmed') {
                $confirmedOffers[] = $offer;
            }
        }

        foreach ($request->contributions as $contribution) {
            if ($contribution->status === 'pending') {
                $pendingPaypal[] = $contribution;
            } elseif ($contribution->status === 'confirmed') {
                $confirmedPaypal[] = $contribution;
            }
        }
    }

    return inertia('FoodRequests/ManageContributions', [
        'pendingOffers' => $pendingOffers,
        'acceptedOffers' => $acceptedOffers,
        'confirmedOffers' => $confirmedOffers,
        'pendingPaypal' => $pendingPaypal,
        'confirmedPaypal' => $confirmedPaypal,
    ]);
}

/**
 * Partner marque une contribution comme reçue physiquement
 */
public function confirmReceived($id)
{
    try {
        $foodOffer = FoodRequestDonation::findOrFail($id);
        
        // Charger la relation food request
        $foodOffer->load('foodRequest');
        
        // Vérifier que c'est accepted
        if ($foodOffer->status !== 'accepted') {
            return back()->withErrors(['error' => 'This offer is not in accepted status']);
        }
        
        // Vérifier que c'est admin OU le propriétaire
        //$isAdmin = auth()->user()->role === 'admin';
        $isOwner = $foodOffer->foodRequest->organization_id === auth()->id();
        
        if (!$isOwner) {
            return back()->withErrors(['error' => 'You are not authorized to confirm this offer']);
        }

        // Mettre à jour
        $foodOffer->update(['status' => 'confirmed']);

        return back()->with('success', 'Contribution marked as received!');
        
    } catch (\Exception $e) {
        \Log::error('Error in confirmReceived: ' . $e->getMessage());
        return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    }
}

/**
 * Partner confirme avoir reçu l'argent PayPal
 */
public function confirmPaypal($id)
{
    $contribution = Contribution::findOrFail($id);

    // Vérifier que c'est bien le partner propriétaire
    if ($contribution->foodRequest->user_id !== auth()->id()) {
        abort(403);
    }

    $contribution->update([
        'status' => 'confirmed',
    ]);

    return redirect()->back()->with('success', 'PayPal contribution confirmed!');
}
public function addPaypalContribution(Request $request)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'contributor_name' => 'nullable|string|max:255'
    ]);

    // Trouver la food request du partner
    $foodRequest = FoodRequest::where('organization_id', auth()->id())->latest()->first();
    
    if (!$foodRequest) {
        return back()->withErrors(['error' => 'No food request found']);
    }

    // Créer la contribution
    Contribution::create([
        'food_request_id' => $foodRequest->id,
        'partner_id' => auth()->id(),
        'amount' => $validated['amount'],
        'contributor_name' => $validated['contributor_name'] ?? 'Anonymous',
        'status' => 'confirmed', // Directement confirmé
    ]);

    return back()->with('success', 'Contribution added successfully!');
}

public function deletePaypalContribution($id)
{
    $contribution = Contribution::findOrFail($id);
    
    // Vérifier autorisation
    if ($contribution->partner_id !== auth()->id() && auth()->user()->role !== 'admin') {
        abort(403);
    }

    $contribution->delete();

    return back()->with('success', 'Contribution deleted');
}

}
