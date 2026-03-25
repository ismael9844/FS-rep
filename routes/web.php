<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FoodRequestController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\DonationMapController;
use App\Http\Controllers\PartnerRequestController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceRequestController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AuthController;
use App\Models\PlacePhoto;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Route model binding for photos
Route::bind('photo', function ($value) {
    return PlacePhoto::findOrFail($value);
});

// Photo deletion route
Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

// Landing pages
Route::get('/home', [LandingpageController::class, 'index']);
Route::get('/dashboard2', [LandingpageController::class, 'index']);

// Dashboard (requires authentication)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Email Confirmation Links (Public - Token-based)
|--------------------------------------------------------------------------
*/

// Pickup confirmation
Route::get('/pickups/confirm/{token}', [PickupController::class, 'confirm'])
    ->name('pickups.confirm');

// Volunteer accept/decline
Route::get('/volunteers/accept/{token}', [VolunteerController::class, 'accept'])
    ->name('volunteers.accept');
Route::get('/volunteers/decline/{token}', [VolunteerController::class, 'decline'])
    ->name('volunteers.decline');

// Food offer accept/decline
Route::get('/food-offers/accept/{token}', [FoodRequestController::class, 'showAcceptForm'])
    ->name('food-offers.accept-form');
Route::post('/food-offers/accept/{token}', [FoodRequestController::class, 'acceptOffer'])
    ->name('food-offers.accept');
Route::get('/food-offers/decline/{token}', [FoodRequestController::class, 'declineOffer'])
    ->name('food-offers.decline');

// Document upload (public with token)
Route::get('/documents/upload', function () {
    return inertia('Documents/Upload');
});
Route::post('/documents/upload', [DocumentController::class, 'uploadWithToken'])
    ->name('documents.upload');
Route::get('/documents/upload-request/{token}', [DocumentController::class, 'showUploadForm'])
    ->name('documents.upload-form');
Route::post('/documents/upload-request/{token}', [DocumentController::class, 'uploadWithToken']);

// Place request email confirmation links
Route::get('/place-requests/accept/{token}', [PlaceController::class, 'showAcceptForm'])
    ->name('place-requests.accept.form');
Route::post('/place-requests/accept/{token}', [PlaceController::class, 'acceptRequest'])
    ->name('place-requests.accept');
Route::get('/place-requests/decline/{token}', [PlaceController::class, 'declineRequest'])
    ->name('place-requests.decline');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
  /*
|--------------------------------------------------------------------------
| Places Management
|--------------------------------------------------------------------------
*/

Route::get('/my-places', [PlaceController::class, 'myPlaces'])
    ->name('my-places');
Route::get('/places', [PlaceController::class, 'index'])
    ->name('places.index');
Route::get('/places/create', [PlaceController::class, 'create'])
    ->name('places.create');
Route::post('/places', [PlaceController::class, 'store'])
    ->name('places.store');
Route::get('/places/{place}', [PlaceController::class, 'show'])
    ->name('places.show');
Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])
    ->name('places.edit');
Route::put('/places/{place}', [PlaceController::class, 'update'])
    ->name('places.update');
Route::delete('/places/{place}', [PlaceController::class, 'destroy'])
    ->name('places.destroy');
Route::delete('/places/{place}/photos/{photo}', [PlaceController::class, 'deletePhoto'])
    ->name('places.photos.destroy');

// Place requests
Route::post('/places/{place}/request', [PlaceController::class, 'requestPlace'])
    ->name('places.request');
    /*
    |--------------------------------------------------------------------------
    | User Verification & Documents
    |--------------------------------------------------------------------------
    */
    
    Route::get('/verifications', [\App\Http\Controllers\Admin\UserVerificationController::class, 'index'])
        ->name('admin.verifications.index');
    Route::post('/verifications/{user}', [\App\Http\Controllers\Admin\UserVerificationController::class, 'update'])
        ->name('admin.verifications.update');
    
    /*
    |--------------------------------------------------------------------------
    | Volunteer Management
    |--------------------------------------------------------------------------
    */
    
    Route::get('/admin/volunteers/verifications', [VolunteerController::class, 'adminPendingVerifications'])
        ->name('admin.volunteers.verifications');
    Route::patch('/admin/volunteers/{id}/verify', [VolunteerController::class, 'updateVerification'])
        ->name('admin.volunteers.updateVerification');
    Route::post('/volunteer/upload-document', [VolunteerController::class, 'uploadDocument'])
        ->name('volunteer.upload-document');
    Route::get('/volunteer/complete-profile', [VolunteerController::class, 'completeProfile'])
        ->name('volunteer.complete-profile');
    Route::post('/volunteer/complete-profile', [VolunteerController::class, 'saveProfile'])
        ->name('volunteer.save-profile');
    Route::get('/volunteer/{id}/edit', [VolunteerController::class, 'edit'])
        ->name('volunteer.edit');
    Route::patch('/volunteer/{id}', [VolunteerController::class, 'update'])
        ->name('volunteer.update');
    Route::get('/volunteer/needs', [VolunteerController::class, 'needs'])
        ->name('volunteer.needs');
    Route::get('/volunteer/profile', [VolunteerController::class, 'profile'])
        ->name('volunteer.profile');
    Route::post('/volunteer/{donation}', [VolunteerController::class, 'store'])
        ->name('volunteer.store');
    Route::get('/volunteers', [VolunteerController::class, 'index'])
        ->name('volunteers');
    
    /*
    |--------------------------------------------------------------------------
    | Document Requests
    |--------------------------------------------------------------------------
    */
    
    Route::post('/admin/request-document', [DocumentRequestController::class, 'store']);
    Route::post('/admin/partners/{partner}/request-document', [PartnerController::class, 'requestDocument'])
        ->middleware(['auth', 'can:admin-action']);
    Route::post('/documents/upload', [DocumentController::class, 'upload']);
    Route::post('/documents/upload', [DocumentController::class, 'store'])
        ->name('documents.store');
    Route::get('/users/{id}/upload-request-document', [UploadController::class, 'showUserUpload']);
    Route::post('/users/{id}/upload-request-document', [UploadController::class, 'uploadUserDocument']);
    Route::get('/partners/{id}/upload-request-document', [UploadController::class, 'showPartnerUpload']);
    Route::post('/partners/{id}/upload-request-document', [UploadController::class, 'uploadPartnerDocument']);
    Route::post('/admin/request-documents', [AdminController::class, 'requestDocuments'])
        ->name('admin.request-documents');
    Route::post('/users/{user}/upload-request-document', [UserController::class, 'uploadRequestDocument']);
    Route::post('/partners/{partner}/upload-request-document', [PartnerController::class, 'uploadRequestDocument']);
    
    // Admin document management
    Route::middleware(['admin'])->group(function () {
        Route::get('/documents/download/{type}/{id}', [UploadController::class, 'downloadDocument']);
        Route::delete('/documents/{type}/{id}', [UploadController::class, 'deleteDocument']);
    });
    
    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    
    Route::get('/admin/notifications', function() {
        $notifications = auth()->user()->notifications
            ->where('type', 'App\\Notifications\\DocumentUploaded')
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'user_name' => $notif->data['user_name'],
                    'document_path' => $notif->data['document_path'],
                    'created_at' => $notif->created_at->toDateTimeString(),
                ];
            });
        return $notifications;
    });
    
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/clear', [NotificationController::class, 'clear'])
        ->name('notifications.clear');
    Route::delete('/notifications/{notification_id}', [NotificationController::class, 'destroy']);
    
    /*
    |--------------------------------------------------------------------------
    | Food Requests & Contributions
    |--------------------------------------------------------------------------
    */

        // Partner contribution management

    Route::post('/food-offers/{id}/confirm-received', [FoodRequestController::class, 'confirmReceived'])
        ->name('food-offers.confirm-received');
    Route::post('/contributions/{id}/confirm', [FoodRequestController::class, 'confirmPaypal'])
        ->name('contributions.confirm');
     Route::get('/food-requests/manage-contributions', [FoodRequestController::class, 'manageContributions'])
        ->name('food-requests.manage-contributions');   
    Route::post('/paypal-contributions/add', [FoodRequestController::class, 'addPaypalContribution']);
    Route::delete('/paypal-contributions/{id}', [FoodRequestController::class, 'deletePaypalContribution']);    
    // Food request management (partners/admins)
    Route::get('/food-requests', [FoodRequestController::class, 'index'])
        ->name('food-requests.index');
    Route::get('/food-requests/create', [FoodRequestController::class, 'create'])
        ->name('food-requests.create');
    Route::post('/food-requests', [FoodRequestController::class, 'store'])
        ->name('food-requests.store');
    Route::get('/food-requests/{foodRequest}', [FoodRequestController::class, 'show'])
        ->name('food-requests.show');
    Route::delete('/food-requests/{foodRequest}', [FoodRequestController::class, 'destroy'])
        ->name('food-requests.destroy');
    
    // Food offers (users contribute food)
    Route::post('/food-requests/{foodRequest}/respond', [FoodRequestController::class, 'respond'])
        ->name('food-requests.respond');
    

    
    // Public food requests view
    Route::get('/requests', [FoodRequestController::class, 'publicIndex'])
        ->name('requests.index');
    
    // Legacy routes (keep for backward compatibility)
    Route::post('/food-requests/send', [FoodRequestController::class, 'send']);
    
    /*
    |--------------------------------------------------------------------------
    | Profile Management
    |--------------------------------------------------------------------------
    */
    
    Route::post('/profile/update-name-privacy', [ProfileController::class, 'updateNamePrivacy'])
        ->name('profile.updatePrivacy');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::get('/profile/donor', [ProfileController::class, 'donorProfile'])
        ->name('profile.donor');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])
        ->name('profile.update-image');
    Route::post('/profile/update-info', [ProfileController::class, 'updateInfo'])
        ->name('profile.update-info');

    /*
    |--------------------------------------------------------------------------
    | User Preferences
    |--------------------------------------------------------------------------
    */
    
    Route::get('/preferences', [UserPreferenceController::class, 'index'])
        ->name('preferences');
    Route::post('/preferences', [UserPreferenceController::class, 'store'])
        ->name('preferences.store');
    Route::patch('/preferences/{id}', [UserPreferenceController::class, 'update'])
        ->name('preferences.update');
    Route::delete('/preferences/{id}', [UserPreferenceController::class, 'destroy'])
        ->name('preferences.destroy');
    
    /*
    |--------------------------------------------------------------------------
    | Donations
    |--------------------------------------------------------------------------
    */
    
    Route::get('/donations/create', function () {
        return Inertia::render('Donations/CreateDonation');
    });
    Route::post('/donations', [DonationController::class, 'store']);
    Route::get('/donations/{id}', [DonationController::class, 'show'])
        ->name('donations.show');
    Route::get('/my-donations', [DonationController::class, 'myDonations'])
        ->name('donations.mine');
    Route::get('/donations/{id}/edit', [DonationController::class, 'edit'])
        ->name('donations.edit');
    Route::put('/donations/{donation}', [DonationController::class, 'update'])
        ->name('donations.update');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])
        ->name('donations.destroy');
    Route::get('/donations', [DonationController::class, 'index'])
        ->name('donations.index');
    
    /*
    |--------------------------------------------------------------------------
    | Donations Map
    |--------------------------------------------------------------------------
    */
    
    Route::get('/donations-map', [DonationMapController::class, 'index'])
        ->name('donations.map');
    Route::get('/api/donations/{donation}', [DonationMapController::class, 'show'])
        ->name('api.donations.show');
    Route::post('/donations-map/update-location', [DonationMapController::class, 'updateLocation'])
        ->name('donations.map.updateLocation');
    
    /*
    |--------------------------------------------------------------------------
    | Pickups
    |--------------------------------------------------------------------------
    */
    
    Route::get('/pickups', [PickupController::class, 'index'])
        ->name('pickups.index');
    Route::get('/pickups/create', [PickupController::class, 'create']);
    Route::post('/pickups', [PickupController::class, 'store']);
    Route::delete('/pickups/{pickup}', [PickupController::class, 'destroy'])
        ->name('pickups.destroy');
    
    /*
    |--------------------------------------------------------------------------
    | Distributions
    |--------------------------------------------------------------------------
    */
    
    Route::get('/distributions', [DistributionController::class, 'index'])
        ->name('distributions');
    
    /*
    |--------------------------------------------------------------------------
    | Partners
    |--------------------------------------------------------------------------
    */
    
    Route::get('/partners', [PartnerController::class, 'index'])
        ->name('partners');
    Route::post('/partners/respond', [PartnerController::class, 'respond']);
    Route::patch('/partners/{partner}/status', [PartnerController::class, 'updateStatus']);
    Route::delete('/partners/{partner}', fn($partner) => \App\Models\Partner::findOrFail($partner)->delete());
    Route::get('/partner/profile', [PartnerController::class, 'profile'])
        ->name('partner.profile');
    Route::get('/partner/history', [PartnerController::class, 'history'])
        ->name('partner.history');
    Route::post('/partner-requests/send', [PartnerRequestController::class, 'sendPartnerRequest']);
    
    /*
    |--------------------------------------------------------------------------
    | Sponsorships
    |--------------------------------------------------------------------------
    */
    
    Route::get('/sponsorships/create', [SponsorshipController::class, 'create'])
        ->name('sponsorships.create');
    Route::post('/sponsorships', [SponsorshipController::class, 'store'])
        ->name('sponsorships.store');
    Route::get('/sponsors', [DashboardController::class, 'getSponsors']);
    
    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    
    // Admin dashboard
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])
        ->name('admin.users');
    Route::get('/admin/donations', [AdminController::class, 'donations'])
        ->name('admin.donations');
    Route::get('/admin/partners', [AdminController::class, 'partners'])
        ->name('admin.partners');
    Route::delete('/admin/users/{user}', fn($user) => \App\Models\User::findOrFail($user)->delete());
    
    // Admin sponsorships
    Route::get('/admin/sponsorships', [SponsorshipController::class, 'index'])
        ->name('admin.sponsorships.index');
    Route::post('/admin/sponsorships/{id}', [SponsorshipController::class, 'update'])
        ->name('admin.sponsorships.update');
    
    /*
    |--------------------------------------------------------------------------
    | Testing Routes (Remove in production)
    |--------------------------------------------------------------------------
    */
    
    Route::get('/mail-test', function() {
        Mail::raw('Test depuis Mailtrap', function ($message) {
            $message->to('test@example.com')->subject('Test Mailtrap');
        });
        return 'Mail sent!';
    });
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';