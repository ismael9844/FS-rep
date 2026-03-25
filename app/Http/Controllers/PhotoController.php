<?php

namespace App\Http\Controllers;

use App\Models\PlacePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
   public function destroy(Place $place, PlacePhoto $placePhoto)
{
    if (Auth::id() !== $place->user_id) {
        abort(403, 'Unauthorized');
    }
    
    if ($placePhoto->place_id !== $place->id) {
        abort(404, 'Photo not found for this place');
    }
    
    $placePhoto->delete();
    
    return response()->json(['message' => 'Photo deleted successfully']);
}
}