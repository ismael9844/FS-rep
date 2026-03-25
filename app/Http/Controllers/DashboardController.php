<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Partner;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('preference');

        // 1. Toutes les donations encore disponibles
        $donations = Donation::where('available_until', '>=', now())
            ->where('status', 'available')
            ->orderBy('available_until', 'asc')
            //->paginate(6)
            //->withQueryString();
            ->get();

        // 2. Récupère les préférences de l’utilisateur
        $pref = $user->preference; // relation hasOne UserPreference

        // 3. Filtrage de matching : au moins un critère doit coller
        $matched = $donations->filter(function($d) use ($pref, $user) {
            if (! $pref) {
                return false;
            }

            // Catégorie
            if (! empty($pref->preferred_categories) &&
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
        $sponsors = Partner::whereHas('sponsorship', function ($q) {
        $q->where('status', 'active')
          ->where('end_at', '>', now());
    })
    ->with(['sponsorship.tier']) // on veut aussi les infos du niveau
    ->get()
    ->sortBy(function ($partner) {
        $order = ['Platinum' => 1, 'Gold' => 2, 'Silver' => 3, 'Bronze' => 4];
        return $order[$partner->sponsorship->tier->name] ?? 999;
    })
    ->values();

        // 4. Rendu Inertia
        return Inertia::render('Dashboard', [
            'user'             => $user,
            'donations'        => $donations,
            'matchedDonations' => $matched,
            'sponsors' => $sponsors,    
        ]);
    }
     public function getSponsors()
{
    $today = Carbon::today();
    
    // Debug 1 date
    \Log::info('Today date: ' . $today);
    
    $sponsors = Sponsorship::with(['partner', 'tier', 'images'])
        ->where('status', 'active')

        ->get();
    
    // Debug 2 nombre de resultats
    \Log::info('Sponsors count: ' . $sponsors->count());
    
    // Debug 3 structure des donnees
    \Log::info('First sponsor structure: ', $sponsors->first() ? $sponsors->first()->toArray() : []);
    
    // Debug 4 relations
    if ($sponsors->first()) {
        \Log::info('Partner loaded: ' . ($sponsors->first()->partner ? 'Yes' : 'No'));
        \Log::info('Tier loaded: ' . ($sponsors->first()->tier ? 'Yes' : 'No'));
        \Log::info('Images loaded: ' . ($sponsors->first()->images ? 'Yes' : 'No'));
    }
    
            return Inertia::render('dashboard', [
            'sponsors'=> $sponsors,

        ]);}
}
