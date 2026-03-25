<?php

namespace App\Http\Controllers;

use App\Models\FoodWasteReport;
use Illuminate\Http\Request;

class FoodWasteReportController extends Controller
{
    // Créer un nouveau rapport de gaspillage alimentaire
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
    }
        $request->validate([
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $report = FoodWasteReport::create([
            'user_id' => auth()->user()->id, // Assurer que l'utilisateur est authentifié
            'category' => $request->category,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'reported_at' => now(),
        ]);

        return response()->json($report, 201); // Réponse avec le rapport créé
    }

    // Obtenir tous les rapports
    public function index()
    {
        $reports = FoodWasteReport::all();
        return response()->json($reports);
    }
}

