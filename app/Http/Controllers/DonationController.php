<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;
use App\Models\FoodRequest;

class DonationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $lat      = $request->query('lat');
        $lng      = $request->query('lng');
        $radius   = $request->query('radius', 10);
        $minQty   = $request->query('min_quantity');
        $fromTime = $request->query('available_from');
        $toTime   = $request->query('available_to');
        $donor    = $request->query('donor_type');
        $keyword  = $request->query('keyword');
        $city     = $request->query('city');
        $postal   = $request->query('postal_code');
        

        // Calcul distance (Haversine)
        $haversine = "(6371 * acos(
            cos(radians(?)) * cos(radians(latitude)) *
            cos(radians(longitude) - radians(?)) +
            sin(radians(?)) * sin(radians(latitude))
        ))";

        $query = Donation::select('*')
            ->selectRaw("$haversine AS distance", [$lat, $lng, $lat])
            ->where('available_until', '>=', now())
            ->notExpired();

        // conditionnal filters
        if ($minQty)   { $query->where('quantity', '>=', $minQty); }
        if ($fromTime) { $query->whereTime('available_from', '<=', $fromTime); }
        if ($toTime)   { $query->whereTime('available_to',   '>=', $toTime);   }
        if ($donor)    { $query->where('donor_type', $donor); }
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }
            if ($request->query('city')) {
                $query->where('city', $request->query('city'));
            }
            if ($request->query('postal_code')) {
                $query->where('postal_code', $request->query('postal_code'));
            }


        $donations = $query
            ->withCount('volunteers') 
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->paginate(15);

        return Inertia::render('Donations/Show', [
            'donation' => $donations->load('user')
        ]);
    }

    public function show($id)
    {
        $donation = Donation::with(['user'])->withCount('volunteers')->findOrFail($id);

        return Inertia::render('Donations/Show', [
            'donation' => $donation
        ]);
    }


    public function store(Request $request)
    {
     $data = $request->validate([
        'title'           => 'required|string',
        'description'     => 'nullable|string',
        'quantity'        => 'required|integer|min:1',
        'unit'            => 'required|string',
        'latitude'        => 'nullable|numeric',
        'longitude'       => 'nullable|numeric',
        'available_from'  => 'nullable|date_format:Y-m-d\TH:i',
        'available_to'    => 'nullable|date_format:H:i',
        'available_until' => 'required|date|after:now',
        'expiration_date' => 'nullable|date|after_or_equal:today',
        'category'        => 'nullable|string',
        'min_quantity'    => 'nullable|integer|min:1',
        'donor_type'      => 'in:individual,organization',
        'city'            => 'nullable|string',
        'postal_code'     => 'nullable|string',
        'need_volunteers' => 'nullable|integer|min:0',
        'volunteer_note'  => 'nullable|string',
     ]);

      $partner = $request->user()->partner; // relation hasOne(Partner::class)
     if ($partner) {
        $data['partner_id'] = $partner->id;
      }

      $donation = $request->user()->donations()->create($data);

     if ($partner) {
        $partner->updateLevel();
     }

      return redirect()
        ->route('dashboard')
        ->with('success', 'Donation added successfully!');
    }

    public function updateQuantity(Request $request, Donation $donation)
    {
        $this->authorize('update', $donation);

        $data = $request->validate([
            'quantity'     => 'required|integer|min:0',
            'min_quantity' => 'sometimes|integer|min:1',
        ]);

        $donation->update($data);

        return response()->json([
            'message'  => 'Quantity updated successfully',
            'donation' => $donation,
        ], Response::HTTP_OK);
    }

    /**
     * delte donnation
     */
    public function destroy(Donation $donation)
    {
        $this->authorize('delete', $donation);

        $donation->delete();

        return response()->json([
            'message' => 'Donation deleted successfully',
        ], Response::HTTP_NO_CONTENT);
    }


    public function search(Request $request)
    {
       $query = Donation::query();

     if ($request->has('category')) {
        $query->where('category', $request->category);
     }

        if ($request->has('min_quantity')) {
        $query->where('quantity', '>=', $request->min_quantity);
     }

        if ($request->has('keywords')) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->keywords . '%')
              ->orWhere('description', 'LIKE', '%' . $request->keywords . '%');
        });
        }

        if ($request->has(['available_from', 'available_until'])) {
        $query->where('available_from', '<=', $request->available_from)
              ->where('available_until', '>=', $request->available_until);
        }

        if ($request->has(['latitude', 'longitude', 'max_distance'])) {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $maxDistance = $request->max_distance;

        $query->whereRaw("
            (6371 * acos(
                cos(radians(?)) * cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(latitude))
            )) < ?
        ", [$latitude, $longitude, $latitude, $maxDistance]);
        }

        $results = $query->get();

        return response()->json($results);
    }

    public function myDonations(Request $request)
    {
        $user = $request->user();

        $donations = Donation::withCount('volunteers')
        ->where('user_id', auth()->id())
        ->get();
        
        return Inertia::render('Donations/MyDonations', [
            'donations' => $donations,
        ]);
    }

    public function getDonationsByUser($userId)
    {
        $donations = Donation::where('user_id', $userId)->get();

        return response()->json($donations);


    }

    public function edit($id)
    {
        $donation = Donation::findOrFail($id);

        $this->authorize('update', $donation);

        return Inertia::render('Donations/Edit', [
        'donation' => $donation,
        ]);
    }

    public function update(Request $request, Donation $donation)
    {
        $this->authorize('update', $donation);

        $data = $request->validate([
        'title'           => 'sometimes|string|max:255',
        'description'     => 'nullable|string',
        'quantity'        => 'sometimes|integer|min:1',
        'unit'            => 'sometimes|string|max:50',
        'available_from'  => 'nullable|date',
        'available_until' => 'sometimes|date',
        'city'            => 'nullable|string|max:100',
        'postal_code'     => 'nullable|string|max:20',
        'expiration_date' => 'nullable|date|after_or_equal:today',
        'need_volunteers' => 'nullable|integer|min:0',
        'volunteer_note'  => 'nullable|string|max:1000',
        ]);

        $donation->update($data);

        return redirect()->route('donations.mine')->with('success', 'Donation updated!');
    }

   public function respondToRequest(Request $request, $id)
{
    $foodRequest = FoodRequest::findOrFail($id);

    $data = $request->validate([
        'quantity'        => 'required|integer|min:1',
        'available_until' => 'required|date|after:now',
    ]);

    Donation::create([
        'title'           => $foodRequest->title,
        'description'     => $foodRequest->description ?? '',
        'quantity'        => $data['quantity'],
        'unit'            => 'servings',
        'available_from'  => now(),
        'available_until' => $data['available_until'],
        'user_id'         => auth()->id(),
        'food_request_id' => $foodRequest->id,
    ]);

    return back()->with('success', 'Your offer has been recorded.');
}



public function getMapDonations(Request $request)
    {
        try {
            $query = Donation::with(['user:id,name'])
                ->where('status', 'available')
                ->where('expires_at', '>', now())
                ->whereNotNull('latitude')
                ->whereNotNull('longitude');

            // Optional filtering by radius
            if ($request->has(['lat', 'lng', 'radius'])) {
                $lat = $request->lat;
                $lng = $request->lng;
                $radius = $request->radius ?? 10; // Default 10km radius

                $query->whereRaw(
                    "( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) <= ?",
                    [$lat, $lng, $lat, $radius]
                );
            }

            $donations = $query->select([
                'id',
                'title',
                'description', 
                'latitude',
                'longitude',
                'address',
                'user_id',
                'expires_at',
                'quantity',
                'status',
                'image_url',
                'created_at'
            ])
            ->orderBy('created_at', 'desc')
            ->limit(100) // Limit for performance
            ->get();

            // Transform data for frontend
            $donationsWithDistance = $donations->map(function ($donation) use ($request) {
                $donationArray = $donation->toArray();
                $donationArray['donor_name'] = $donation->user ? $donation->user->name : 'Anonymous';
                $donationArray['image'] = $donation->image_url;
                
                // Calculate distance if user coordinates are provided
                if ($request->has(['lat', 'lng'])) {
                    $donationArray['distance'] = $this->calculateDistance(
                        $request->lat,
                        $request->lng,
                        $donation->latitude,
                        $donation->longitude
                    );
                } else {
                    $donationArray['distance'] = 0;
                }

                return $donationArray;
            });

            return response()->json($donationsWithDistance);

        } catch (\Exception $e) {
            \Log::error('Error fetching map donations: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Unable to fetch donations',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a donation request
     */
    public function requestDonation(Request $request, $donationId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Authentication required'], 401);
            }

            $donation = Donation::findOrFail($donationId);

            // Check if donation is still available
            if ($donation->status !== 'available') {
                return response()->json([
                    'error' => 'Donation is no longer available'
                ], 400);
            }

            // Check if donation has expired
            if ($donation->expires_at <= now()) {
                return response()->json([
                    'error' => 'Donation has expired'
                ], 400);
            }

            // Check if user already requested this donation
            $existingRequest = DonationRequest::where('donation_id', $donationId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'error' => 'You have already requested this donation'
                ], 400);
            }

            // Check if user is the donor
            if ($donation->user_id === $user->id) {
                return response()->json([
                    'error' => 'You cannot request your own donation'
                ], 400);
            }

            // Create the donation request
            DB::beginTransaction();

            $donationRequest = DonationRequest::create([
                'donation_id' => $donationId,
                'user_id' => $user->id,
                'status' => 'pending',
                'requested_at' => now(),
                'message' => $request->input('message', '')
            ]);

            // Optionally mark donation as reserved if it's first-come-first-served
            // You might want to implement a different logic here
            $donation->update(['status' => 'reserved']);

            // Send notification to donor (implement as needed)
            // Notification::send($donation->user, new DonationRequestNotification($donationRequest));

            DB::commit();

            return response()->json([
                'message' => 'Donation request sent successfully',
                'request' => $donationRequest
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating donation request: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Unable to process donation request',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get donations near a location
     */
    public function getNearbyDonations(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1|max:50'
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->radius ?? 10; // Default 10km

        try {
            $donations = Donation::with(['user:id,name'])
                ->where('status', 'available')
                ->where('expires_at', '>', now())
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->whereRaw(
                    "( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) <= ?",
                    [$lat, $lng, $lat, $radius]
                )
                ->orderByRaw(
                    "( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) )",
                    [$lat, $lng, $lat]
                )
                ->limit(50)
                ->get();

            $donationsWithDistance = $donations->map(function ($donation) use ($lat, $lng) {
                $donationArray = $donation->toArray();
                $donationArray['donor_name'] = $donation->user ? $donation->user->name : 'Anonymous';
                $donationArray['image'] = $donation->image_url;
                $donationArray['distance'] = $this->calculateDistance(
                    $lat,
                    $lng,
                    $donation->latitude,
                    $donation->longitude
                );
                return $donationArray;
            });

            return response()->json($donationsWithDistance);

        } catch (\Exception $e) {
            \Log::error('Error fetching nearby donations: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Unable to fetch nearby donations',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get urgent donations (expiring within 24 hours)
     */
    public function getUrgentDonations()
    {
        try {
            $urgentThreshold = now()->addHours(24);

            $donations = Donation::with(['user:id,name'])
                ->where('status', 'available')
                ->where('expires_at', '>', now())
                ->where('expires_at', '<=', $urgentThreshold)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('expires_at', 'asc')
                ->limit(20)
                ->get();

            $donationsFormatted = $donations->map(function ($donation) {
                $donationArray = $donation->toArray();
                $donationArray['donor_name'] = $donation->user ? $donation->user->name : 'Anonymous';
                $donationArray['image'] = $donation->image_url;
                $donationArray['distance'] = 0; // Will be calculated on frontend
                return $donationArray;
            });

            return response()->json($donationsFormatted);

        } catch (\Exception $e) {
            \Log::error('Error fetching urgent donations: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Unable to fetch urgent donations',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $latDiff = deg2rad($lat2 - $lat1);
        $lngDiff = deg2rad($lng2 - $lng1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lngDiff / 2) * sin($lngDiff / 2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return round($distance, 1);
    }

    /**
     * Get donation statistics for dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_donations' => Donation::where('status', 'available')->count(),
                'urgent_donations' => Donation::where('status', 'available')
                    ->where('expires_at', '>', now())
                    ->where('expires_at', '<=', now()->addHours(24))
                    ->count(),
                'completed_donations' => Donation::where('status', 'completed')->count(),
                'total_requests' => DonationRequest::count(),
            ];

            return response()->json($stats);

        } catch (\Exception $e) {
            \Log::error('Error fetching donation stats: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Unable to fetch statistics'
            ], 500);
        }
    }






}























