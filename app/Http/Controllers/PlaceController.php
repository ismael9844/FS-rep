<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\PlacePhoto;
use App\Mail\PlaceRequestNotification;
use App\Mail\PlaceRequestAccepted;
use App\Mail\PlaceRequestRejected;
use GuzzleHttp\Client;

class PlaceController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $places = Place::with(['photos', 'user'])->get();
        
        // Transform photo URLs to ImgBB URLs (they're already full URLs)
        $places = $places->map(function ($place) {
            $place->photos = $place->photos->map(function ($photo) {
                $photo->url = $photo->path; // ImgBB URLs are stored in 'path'
                return $photo;
            });
            return $place;
        });
        
        return Inertia::render('PlacesList', compact('places'));
    }

    public function create()
    {
        return Inertia::render('PlaceCreate');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'google_maps_link' => 'nullable|url',
            'contact_info' => 'required|string',
            'availability' => 'required|date',
            'photos.*' => 'nullable|image|max:5120'
        ]);

        $place = Auth::user()->places()->create($data);

        // Upload photos to ImgBB
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                try {
                    $imageUrl = $this->uploadToImgBB($photo);
                    $place->photos()->create([
                        'path' => $imageUrl // Store full ImgBB URL
                    ]);
                } catch (\Exception $e) {
                    \Log::error('ImgBB upload error: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('places.index')->with('success', 'Place created successfully!');
    }

    public function show(Place $place)
    {
        $place->load('photos', 'requests.user');
        $isOwner = Auth::id() === $place->user_id;
        
        // Transform photo URLs
        $place->setRelation('photos', $place->photos->map(function ($photo) {
            $photo->url = $photo->path;
            return $photo;
        }));
        
        return Inertia::render('PlaceRequests', compact('place', 'isOwner'));
    }

    public function edit(Place $place) 
    {
        if (Auth::id() !== $place->user_id) {
            abort(403, 'Unauthorized');
        }
        
        $place->load('photos');
        
        // Transform URLs
        $place->setRelation('photos', $place->photos->map(function ($photo) {
            $photo->url = $photo->path; // ImgBB URL
            return $photo;
        }));
        
        return Inertia::render('PlaceEdit', compact('place'));
    }

    public function update(Request $request, Place $place)
    {
        if (Auth::id() !== $place->user_id) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'google_maps_link' => 'nullable|url',
            'contact_info' => 'required|string',
            'availability' => 'required|date',
            'photos.*' => 'nullable|image|max:5120'
        ]);

        $place->update($data);

        // Upload new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                try {
                    $imageUrl = $this->uploadToImgBB($photo);
                    $place->photos()->create([
                        'path' => $imageUrl
                    ]);
                } catch (\Exception $e) {
                    \Log::error('ImgBB upload error: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('places.index')->with('success', 'Place updated successfully!');
    }

    public function destroy(Place $place)
    {
        if (Auth::id() !== $place->user_id) {
            abort(403, 'Unauthorized');
        }

        // Note: ImgBB doesn't provide delete API, old images stay but don't count against quota
        $place->delete();

        return redirect()->route('places.index')->with('success', 'Place deleted successfully!');
    }

    public function myPlaces()
    {
        $places = auth()->user()->places()->with('photos')->get();
        
        // Transform URLs
        $places = $places->map(function ($place) {
            $place->photos = $place->photos->map(function ($photo) {
                $photo->url = $photo->path;
                return $photo;
            });
            return $place;
        });
        
        return Inertia::render('MyPlaces', compact('places'));
    }

    public function deletePhoto(Place $place, PlacePhoto $photo)
    {
        if ($photo->place_id !== $place->id) {
            abort(404, 'Photo not found for this place');
        }
        
        if (Auth::id() !== $place->user_id) {
            abort(403, 'Unauthorized');
        }
        
        // Delete from database (ImgBB doesn't provide delete API)
        $photo->delete();
        
        return redirect()->back()->with('success', 'Photo deleted successfully');
    }

    /**
     * Request to use a place
     */
    public function requestPlace(Request $request, Place $place)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Generate confirmation token
        $token = Str::random(60);

        // Create request
        $placeRequest = PlaceRequest::create([
            'place_id' => $place->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'status' => 'pending',
            'confirmation_token' => $token,
        ]);

        // Send email to place owner
        try {
            Mail::to($place->user->email)->send(
                new PlaceRequestNotification($placeRequest, $place, Auth::user(), $token)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send place request email: ' . $e->getMessage());
        }

        return back()->with('success', 'Your request has been sent to the place owner!');
    }

    /**
     * Show accept form
     */
    public function showAcceptForm($token)
    {
        $placeRequest = PlaceRequest::where('confirmation_token', $token)
            ->where('status', 'pending')
            ->with(['place', 'user'])
            ->firstOrFail();

        return Inertia::render('PlaceRequests/AcceptRequest', [
            'placeRequest' => $placeRequest,
            'place' => $placeRequest->place
        ]);
    }

    /**
     * Accept place request
     */
    public function acceptRequest(Request $request, $token)
    {
        $validated = $request->validate([
            'scheduled_date' => 'required|date|after:now',
            'partner_note' => 'nullable|string|max:1000',
        ]);

        $placeRequest = PlaceRequest::where('confirmation_token', $token)
            ->where('status', 'pending')
            ->with(['place', 'user'])
            ->firstOrFail();

        // Update request
        $placeRequest->update([
            'status' => 'approved',
            'scheduled_date' => $validated['scheduled_date'],
            'partner_note' => $validated['partner_note'] ?? null,
        ]);

        // Send confirmation email to requester
        try {
            Mail::to($placeRequest->user->email)->send(
                new PlaceRequestAccepted($placeRequest, $placeRequest->place)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send acceptance email: ' . $e->getMessage());
        }

        return redirect()->route('places.show', $placeRequest->place_id)
            ->with('success', 'Request approved successfully!');
    }

    /**
     * Decline place request
     */
    public function declineRequest($token)
    {
        $placeRequest = PlaceRequest::where('confirmation_token', $token)
            ->where('status', 'pending')
            ->with(['place', 'user'])
            ->firstOrFail();

        $placeRequest->update(['status' => 'rejected']);

        // Send rejection email
        try {
            Mail::to($placeRequest->user->email)->send(
                new PlaceRequestRejected($placeRequest->place)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->route('places.show', $placeRequest->place_id)
            ->with('success', 'Request declined.');
    }

    /**
     * Upload image to ImgBB
     */
    private function uploadToImgBB($file)
    {
        $client = new Client(['verify' => false]); // Disable SSL verification for local dev
        
        $response = $client->post('https://api.imgbb.com/1/upload', [
            'form_params' => [
                'key' => env('IMGBB_API_KEY'),
                'image' => base64_encode(file_get_contents($file->getRealPath()))
            ]
        ]);

        $result = json_decode($response->getBody(), true);
        
        if (!isset($result['success']) || !$result['success']) {
            throw new \Exception('ImgBB upload failed');
        }
        
        return $result['data']['url'];
    }
}