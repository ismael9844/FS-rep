<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Notifications\VerificationStatusUpdated;

class UserVerificationController extends Controller
{
    public function index()
    {
        // Récupérer SEULEMENT les users qui ont un volunteer
        $users = User::whereHas('volunteer')->get();
        
        // Créer un objet indexé par user_id avec les données volunteer
        $volunteers = Volunteer::whereIn('user_id', $users->pluck('id'))
                                ->get()
                                ->keyBy('user_id');

        return Inertia('Admin/UserVerification/Index', [
            'users' => $users,
            'volunteers' => $volunteers
        ]);
    }

   public function update(Request $request, User $user)
    {
        $request->validate([
            'verification_status' => 'required|in:pending,approved,declined'
        ]);

        $volunteer = $user->volunteer;
        
        if (!$volunteer) {
            return redirect()->back()->with('error', 'No volunteer record found');
        }
        
        // Stocker l'ancien statut pour comparaison (optionnel)
        $oldStatus = $volunteer->verification_status;
        
        // Mettre à jour le statut
        $volunteer->update([
            'verification_status' => $request->verification_status
        ]);

        // Déclencher la notification
        $user->notify(new VerificationStatusUpdated($request->verification_status));

        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
