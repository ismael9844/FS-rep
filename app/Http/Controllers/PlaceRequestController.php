<?php

namespace App\Http\Controllers;

use App\Models\PlaceRequest;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceRequestController extends Controller
{
    public function store(Place $place, Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:500'
        ]);

        $place->requests()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true]);
    }

    public function update(PlaceRequest $request, Request $req)
    {
        $request->update([
            'status' => $req->status
        ]);

        // Optionally, notify the user here

        return response()->json(['success' => true]);
    }
}
