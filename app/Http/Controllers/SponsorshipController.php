<?php


namespace App\Http\Controllers;

use App\Models\Sponsorship;
use App\Models\SponsorshipTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Partner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\SponsorshipRequested;



class SponsorshipController extends Controller
{
    // ADMIN : liste des demandes
    public function index()
    {

        $requests = Sponsorship::with('partner.user', 'tier', 'admin')
            ->orderByDesc('created_at')
            ->get();
        $sponsorsByLevel = [
    'platinum' => Partner::where('sponsor_level', 'platinum')->get(),
    'gold' => Partner::where('sponsor_level', 'gold')->get(),
    'silver' => Partner::where('sponsor_level', 'silver')->get(),
    'bronze' => Partner::where('sponsor_level', 'bronze')->get(),
];    

        return Inertia::render('Admin/Sponsorships/Index', [
            'requests' => $requests,
            'sponsorsByLevel' => $sponsorsByLevel

        ]);
    }
    public function getActiveSponsorImages()
{
    $today = Carbon::today();

    $sponsors = Sponsorship::where('status', 'active')
        ->where('start_at', '<=', $today)
        ->where('end_at', '>=', $today)
        ->select('images') // on ne récupère que les images
        ->get();

    // aplatir pour ne renvoyer qu’un tableau d’URLs
    $allImages = $sponsors->flatMap(function ($s) {
        return $s->images ?: [];
    })->values();

    return response()->json($allImages);
}

    // PARTNER : formulaire de création
    public function create()
    {
            $partnerId = auth()->user()->partner->id;

    
    // 2. détecte une demande existante active ou en attente
    $existing = Sponsorship::where('partner_id', $partnerId)
        ->whereIn('status', ['pending','active'])
        ->with('tier')
        ->first();
        $tiers = SponsorshipTier::orderBy('price')->get();

    return Inertia::render('Partner/Sponsorships/Create', [
        'tiers'    => $tiers,
        'existing' => $existing,   
        ]);
    }

    // PARTNER : stockage de la demande
    public function store(Request $request)
{
    $request->validate([
        'tier_id'    => 'nullable|exists:sponsorship_tiers,id',
        'images.*'   => 'nullable|image|max:2048',
    ]);

    // 1️⃣ Stocke les chemins des images uploadées
    $paths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $paths[] = $img->store('sponsorships', 'public');
        }
    }

    // 2️⃣ Crée la sponsorship ET la récupère dans $sponsorship
    $sponsorship = Sponsorship::create([
        'partner_id' => Auth::user()->partner->id,
        'tier_id'    => $request->tier_id,
        'admin_id'   => 1,        // ou null, ou choisir dynamiquement
        'status'     => 'pending',
        'images'     => $paths,
    ]);

    // 3️⃣ Notifier tous les admins
    $admins = User::where('role', 'admin')->get();
    Notification::send($admins, new SponsorshipRequested($sponsorship));

    // 4️⃣ Notifier le partenaire qui vient de créer la demande
    Auth::user()->notify(new SponsorshipRequested($sponsorship));

    // 5️⃣ Redirection
    return redirect()
        ->route('sponsorships.create')
        ->with('success', 'Your sponsorship request has been sent.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:active,cancelled'
    ]);

    $sponsorship = Sponsorship::with('tier')->findOrFail($id);

    $sponsorship->status = $request->status;

    if ($request->status === 'active') {
        $sponsorship->start_at = now();
        $sponsorship->end_at = now()->addDays($sponsorship->tier?->duration_days ?? 30);
    }

    $sponsorship->admin_id = auth()->id();
    $sponsorship->save();


    return back()->with('success', 'Sponsorship request updated.');
}

}

