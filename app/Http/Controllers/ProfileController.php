<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Donation;
use App\Models\Partner;
use App\Models\Volunteer;
use App\Models\Contribution; 
use App\Models\FoodRequestDonation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use GuzzleHttp\Client;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status'          => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show "My Donations" page.
     */
    public function myDonations(Request $request)
    {
        $donations = $request->user()->donations;
        return Inertia::render('Donations/MyDonations', [
            'donations' => $donations
        ]);
    }

    /**
     * Donor/Partner profile page.
     */
    public function donorProfile()
    {
        $user = auth()->user();

        // 1) Donations made by this user
        $donations = Donation::where('user_id', $user->id)
                             ->latest()
                             ->get();

        // 2) Partner or volunteer info
        $partnerInfo   = null;
        if ($user->role !== 'receiver' && $user->partnerProfile) {
            $partnerInfo = $user->partnerProfile;
        }

        $volunteerInfo = null;
        if ($user->role === 'receiver' && $user->volunteerProfile) {
            $volunteerInfo = $user->volunteerProfile;
        }

        // 3) Contributions (for partner & receiver)
        $myContributions = [];
        if ($user->role === 'partner' && $user->partnerProfile) {
            // fetch only this partner's contributions
            $myContributions = $user->partnerProfile
                ->contributions()
                ->with('partner')
                ->latest()
                ->get();
        }
        
        $foodRequestDonations = FoodRequestDonation::with(['foodRequest.organization'])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'food_request_id' => $item->food_request_id,
                    'created_at' => $item->created_at,
                ];
            });
            
        $affiliatedPartners = [];

        if ($user->role === 'organization') {
            $affiliatedPartners = DB::table('partner_requests')
                ->join('partners', 'partner_requests.partner_id', '=', 'partners.id')
                ->join('users', 'partners.user_id', '=', 'users.id')
                ->where('partner_requests.user_id', $user->id)
                ->where('partner_requests.status', 'accepted')
                ->select(
                    'partners.id',
                    'partners.name',
                    'partners.type',
                    'partners.address',
                    'partners.contact_email',
                    'partners.contact_phone',
                    'partners.status',
                    'users.profile_image',
                    'partner_requests.created_at as approved_at'
                )
                ->get();
        }
        
        // Check if user is organization
        $receivedFoodDonations = collect(); 
        if ($user->role === 'organization') {
            // Get food donations received in response to this organization's requests
            $receivedFoodDonations = FoodRequestDonation::with(['user', 'foodRequest'])
                ->whereHas('foodRequest', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->get()
                ->map(function ($donation) {
                    return [
                        'id' => $donation->id,
                        'title' => $donation->title,
                        'quantity' => $donation->quantity,
                        'unit' => $donation->unit,
                        'created_at' => $donation->created_at,
                        'donor_name' => optional($donation->donor)->name,
                    ];
                });
        }

        return Inertia::render('Profile/DonorProfile', [
            'user'            => $user,
            'donations'       => $donations,
            'partnerInfo'     => $partnerInfo,
            'volunteerInfo'   => $volunteerInfo,
            'myContributions' => $myContributions,
            'foodRequestDonations' => $foodRequestDonations,
            'affiliatedPartners' => $affiliatedPartners,
            'receivedFoodDonations' => $receivedFoodDonations,
        ]);
    }

    public function updateNamePrivacy(Request $request)
    {
        $user = auth()->user();

        // Si on reçoit "Anonymous", on stocke le vrai nom et on remplace
        if ($request->name !== 'Anonymous') {
            $user->name = $user->real_name; // garder le vrai nom
        } else {
            $user->real_name = $user->name; // garder le vrai nom
            $user->name = 'Anonymous';
        }

        $user->save();

        return back()->with('success', 'Privacy updated.');
    }

    /**
     * This method had an unclosed brace: we've now fixed it
     * and also added myContributions here too.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        \Log::info('User data:', [
            'user_id'              => $user->id,
            'user_role'            => $user->role,
            'has_partner_profile'  => $user->partnerProfile !== null,
            'partner_profile'      => $user->partnerProfile,
        ]);

        // Determine which donations to show
        if ($user->role !== 'receiver') {
            $donations = $user->partnerProfile
                ? $user->partnerProfile->donations()->latest()->get()
                : collect();
        } else {
            $donations = $user->donations;
        }

        // Partner & Volunteer info
        $partnerInfo   = null;
        $volunteerInfo = null;
        if ($user->role !== 'receiver' && $user->partnerProfile) {
            $partnerInfo = $user->partnerProfile;
        } else {
            $volunteerInfo = $user->volunteerProfile;
        }

        // Contributions for partner & receiver
        $myContributions = [];
        if (in_array($user->role, ['partner','receiver'])) {
            $myContributions = Contribution::with('partner')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }
        
        $foodRequestDonations = FoodRequestDonation::with(['foodRequest.organization'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return Inertia::render('Profile/DonorProfile', [
            'user'            => $user,
            'donations'       => $donations,
            'partnerInfo'     => $partnerInfo,
            'volunteerInfo'   => $volunteerInfo,
            'myContributions' => $myContributions,
            'foodRequestDonations' => $foodRequestDonations,
        ]);
    }

    /**
     * Update user profile image using Cloudinary
     */


    public function updateImage(Request $request)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $user = $request->user();
    
    try {
        $client = new Client([
            'verify' => false  // ⚠️ DÉSACTIVE LA VÉRIFICATION SSL (local uniquement)
        ]);
        
        $response = $client->post('https://api.imgbb.com/1/upload', [
            'form_params' => [
                'key' => env('IMGBB_API_KEY'),
                'image' => base64_encode(file_get_contents($request->file('profile_image')->getRealPath()))
            ]
        ]);

        $result = json_decode($response->getBody(), true);
        
        if (!isset($result['success']) || !$result['success']) {
            throw new \Exception('ImgBB upload failed');
        }
        
        $imageUrl = $result['data']['url'];
        
        $user->profile_image = $imageUrl;
        $user->save();
        
        \Log::info('Image uploaded to ImgBB', ['url' => $imageUrl]);
        
        return back()->with('success', 'Profile image updated successfully!');
        
    } catch (\Exception $e) {
        \Log::error('Upload error: ' . $e->getMessage());
        return back()->withErrors(['profile_image' => 'Failed to upload: ' . $e->getMessage()]);
    }
}
   public function updateInfo(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name'             => 'required|string|max:255',
        'email'            => 'required|email|unique:users,email,' . $user->id,
        'current_password' => 'required|current_password',
        'password'         => 'nullable|min:8|confirmed',
    ]);

    $user->name  = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = \Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully!');
}
}