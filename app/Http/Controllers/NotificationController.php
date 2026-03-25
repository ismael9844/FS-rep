<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PartnerRequest;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Notification;
use App\Models\Partner;


class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        // Toutes les notifications en base (via DatabaseNotifications)
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        // Toutes les demandes de partenariat pour ce partner (lié à l'utilisateur)
        $partnerRequests = PartnerRequest::where('partner_id', $user->partner->id)
                                         ->get(['id', 'status']);

        return Inertia::render('Notifications/Index', [
            'notifications'   => $notifications,
            'partnerRequests' => $partnerRequests,
        ]);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer'
        ]);

        $notification = Auth::user()->notifications()
            ->where('id', $request->notification_id)
            ->first();

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Notification not found'], 404);
    }


    public function clear(Request $request)
    {
        $user = $request->user();
        $user->notifications()->delete();

        return redirect()->back()->with('success', 'Notifications cleared.');
    }
}
