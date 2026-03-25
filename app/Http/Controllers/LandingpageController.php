<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingpageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->load('preference');
        }
        
        // 1. Toutes les donations encore disponibles
        $donations = Donation::where('available_until', '>=', now())
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Récupère les préférences de l'utilisateur (avec valeur par défaut)
        $pref = $user ? $user->preference : null;

        // 3. Filtrage de matching : au moins un critère doit coller
        $matched = $donations->filter(function($d) use ($pref, $user) {
            // Si pas d'utilisateur connecté ou pas de préférences, pas de matching
            if (!$user || !$pref) {
                return false;
            }

            // Catégorie
            if (!empty($pref->preferred_categories) &&
                in_array($d->category, $pref->preferred_categories)) {
                return true;
            }

            // Quantité minimale
            if ($d->quantity >= $pref->min_quantity) {
                return true;
            }

            // Fenêtre horaire
            if ($pref->available_from && $pref->available_until &&
                $d->available_from <= $pref->available_from &&
                $d->available_until >= $pref->available_until) {
                return true;
            }

            // Distance (Haversine)
            if ($pref->max_distance && $user->latitude && $user->longitude) {
                $lat1 = $user->latitude;
                $lng1 = $user->longitude;
                $lat2 = $d->latitude;
                $lng2 = $d->longitude;
                $theta = $lng1 - $lng2;
                $dist =  sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
                         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $km = $miles * 1.609344;
                if ($km <= $pref->max_distance) {
                    return true;
                }
            }

            return false;
        })->values();

        // 4. Rendu Inertia
        return Inertia::render('Dashboard2', [
            'user'             => $user,
            'donations'        => $donations,
            'matchedDonations' => $matched,
        ]);
    }
}
