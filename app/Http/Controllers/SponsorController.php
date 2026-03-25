<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class SponsorController extends Controller
{

 public function getActiveSponsors()
    {
        try {
            $today = Carbon::today();

            // Récupère tous les champs `images` des sponsorships actifs
            $paths = Sponsorship::where('status', 'active')
                ->where('start_at', '<=', $today)
                ->where('end_at', '>=', $today)
                ->pluck('images') // renvoie une Collection d’array
                ->flatten()      // aplatit en un seul array
                ->filter()       // supprime les valeurs null/vides
                ->unique()       // retire les doublons
                ->values();      // réindexe de 0

            // Renvoie simplement un tableau de chaînes
            return response()->json($paths);

        } catch (\Throwable $e) {
            // Log l’erreur et renvoie un message clair
            \Log::error('Erreur sponsors-images : '.$e->getMessage());
            return response()->json([
                'error' => 'Impossible de récupérer les images sponsors'
            ], 500);
        }
    }
}
