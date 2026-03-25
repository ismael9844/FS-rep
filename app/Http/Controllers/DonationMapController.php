<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DonationMapController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer toutes les donations actives avec leurs coordonnées
        $donations = Donation::with(['user'])
            ->where('status', 'available')
            ->where('available_until', '>', now())
            ->get();

        // Enrichir les donations avec les coordonnées géographiques
        $donationsWithCoordinates = $donations->map(function ($donation) {
            $coordinates = $this->getCoordinates($donation->code_postal, $donation->city);
            
            return [
                'id' => $donation->id,
                'title' => $donation->title,
                'description' => $donation->description,
                'quantity' => $donation->quantity,
                'food_type' => $donation->food_type,
                'category' => $donation->category,
                'longitude' => $donation->longitude,
                'latitude' => $donation->latitude,
                'status' => $donation->status,
                'city' => $donation->city,
                'code_postal' => $donation->code_postal,
                'available_until' => $donation->available_until,
                'created_at' => $donation->created_at,
                'donor_name' => $donation->user->name ?? 'Anonyme',
                'donor_phone' => $donation->user->phone ?? null,
                'coordinates' => $coordinates,
                'is_urgent' => $this->isExpiringSoon($donation->available_until),
            ];
        })->filter(function ($donation) {
            // Filtrer les donations sans coordonnées valides
            return $donation['coordinates']['lat'] !== null && $donation['coordinates']['lng'] !== null;
        })->values();

        return Inertia::render('DonationMap', [
            'donations' => $donationsWithCoordinates,
            'user' => auth()->user(),
            'mapCenter' => $this->getMapCenter($donationsWithCoordinates),
        ]);
    }

    public function updateLocation(Request $request)
{
    $request->validate([
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180'
    ]);
    
    // Store user location in session or database
    session(['user_location' => [
        'lat' => $request->latitude,
        'lng' => $request->longitude
    ]]);
    
return ;
}

    private function getCoordinates($codePostal, $city)
    {
        // Utiliser le cache pour éviter les appels API répétés
        $cacheKey = "coordinates_{$codePostal}_{$city}";
        
        return Cache::remember($cacheKey, 3600, function () use ($codePostal, $city) {
            try {
                // Utiliser l'API Nominatim (OpenStreetMap) - gratuite
                $query = urlencode("{$codePostal} {$city}, France");
                $response = Http::timeout(5)->get("https://nominatim.openstreetmap.org/search", [
                    'q' => $query,
                    'format' => 'json',
                    'limit' => 1,
                    'countrycodes' => 'fr'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data)) {
                        return [
                            'lat' => (float) $data[0]['lat'],
                            'lng' => (float) $data[0]['lon'],
                        ];
                    }
                }
            } catch (\Exception $e) {
                \Log::error("Geocoding error for {$codePostal} {$city}: " . $e->getMessage());
            }

            // Fallback : coordonnées par défaut (centre de la France)
            return [
                'lat' => 46.603354,
                'lng' => 1.888334,
            ];
        });
    }

    private function getMapCenter($donations)
    {
        if ($donations->isEmpty()) {
            return ['lat' => 46.603354, 'lng' => 1.888334]; // Centre de la France
        }

        $validDonations = $donations->filter(function ($donation) {
            return $donation['coordinates']['lat'] !== 46.603354; // Exclure les coordonnées par défaut
        });

        if ($validDonations->isEmpty()) {
            return ['lat' => 46.603354, 'lng' => 1.888334];
        }

        $avgLat = $validDonations->avg('coordinates.lat');
        $avgLng = $validDonations->avg('coordinates.lng');

        return [
            'lat' => $avgLat,
            'lng' => $avgLng,
        ];
    }

    private function isExpiringSoon($availableUntil)
    {
        $now = now();
        $nextDay = $now->copy()->addDay();
        
        return $availableUntil <= $nextDay;
    }

    public function show(Donation $donation)
    {
        $donation->load(['user']);
        
        return response()->json([
            'id' => $donation->id,
            'title' => $donation->title,
            'description' => $donation->description,
            'quantity' => $donation->quantity,
            'food_type' => $donation->food_type,
            'status' => $donation->status,
            'longitude' => $donation->longitude,
            'latitude' => $donation->latitude,
            'category' => $donation->category,
            'city' => $donation->city,
            'code_postal' => $donation->code_postal,
            'available_until' => $donation->available_until,
            'created_at' => $donation->created_at,
            'donor_name' => $donation->user->name ?? 'Anonyme',
            'donor_phone' => $donation->user->phone ?? null,
            'is_urgent' => $this->isExpiringSoon($donation->available_until),
        ]);
    }
}