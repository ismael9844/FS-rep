<?php

namespace App\Http\Controllers;

use App\Models\UserPreference;
use App\Models\Donation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserPreferenceController extends Controller
{
    /**
     * Affiche le formulaire de préférences et les matches
     */
    public function index()
{
    $prefs = auth()->user()->preference;

    $categories = ['Fruits', 'Vegetables', 'Meals', 'Desserts'];
    $matched = collect();

    if ($prefs) {
        $query = \App\Models\Donation::query();

        // 👉 Toujours filtrer par catégories choisies (priorité absolue)
  if (!empty($prefs->preferred_categories) || !empty($prefs->min_quantity)) {
    $query->where(function ($q) use ($prefs) {
        if (!empty($prefs->preferred_categories)) {
            $q->whereIn('category', $prefs->preferred_categories);
        }

        if (!empty($prefs->min_quantity)) {
            $q->where('quantity', '>=', $prefs->min_quantity);
        }
    });
}


        if (!empty($prefs->max_distance)) {
            // ici tu pourras ajouter la logique de distance
        }

        // 👉 Tri dans l’ordre des préférences
        if (!empty($prefs->preferred_categories)) {
            $query->orderByRaw(
                "FIELD(category, '" . implode("','", $prefs->preferred_categories) . "')"
            );
        }

        $matched = $query->get();
    }

    return Inertia::render('Preferences', [
        'preferences' => $prefs,
        'categories'  => $categories,
        'matched'     => $matched,
    ]);
}


    /**
     * Crée les préférences
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'preferred_categories' => 'nullable|array',
            'min_quantity'         => 'nullable|integer|min:1',
            'max_distance'         => 'nullable|integer|min:1',
            'available_from'       => 'nullable|date_format:H:i',
            'available_until'      => 'nullable|date_format:H:i',
        ]);

        auth()->user()->preference()->create($data);

        return redirect()->route('preferences');
    }

    /**
     * Met à jour les préférences
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'preferred_categories' => 'nullable|array',
            'min_quantity'         => 'nullable|integer|min:1',
            'max_distance'         => 'nullable|integer|min:1',
            'available_from'       => 'nullable|date_format:H:i',
            'available_until'      => 'nullable|date_format:H:i',
        ]);

        $pref = UserPreference::where('user_id', auth()->id())->findOrFail($id);
        $pref->update($data);

        return redirect()->route('preferences');
    }

    /**
     * Supprime les préférences
     */
    public function destroy($id)
    {
        $pref = UserPreference::where('user_id', auth()->id())->findOrFail($id);
        $pref->delete();

        return redirect()->route('preferences');
    }
}
