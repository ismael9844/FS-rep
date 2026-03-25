<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\FoodRequest;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    // Sauvegarde d’une contribution
    public function store(Request $request, FoodRequest $foodRequest)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        Contribution::create([
            'partner_id'     => $request->user()->id,
            'food_request_id'=> $foodRequest->id,
            'amount'         => $data['amount'],
        ]);

        return back()->with('success', 'Thank you for your contribution!');
    }
    
}
