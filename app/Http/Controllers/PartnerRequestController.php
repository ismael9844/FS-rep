<?php

namespace App\Http\Controllers;

use App\Models\PartnerRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use App\Notifications\PartnerRequestReceived;

class PartnerRequestController extends Controller
{
    public function sendPartnerRequest(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
        ]);

        // Créer la demande de partenariat
        $partnerRequest = new PartnerRequest();
        $partnerRequest->partner_id = $request->partner_id;
        $partnerRequest->user_id = auth()->user()->id; // L'utilisateur actuel
        $partnerRequest->status = 'pending';
        $partnerRequest->save();

        // Optionnel : envoyer une notification au partenaire
        $partner = Partner::find($request->partner_id);
        $partner->user->notify(new PartnerRequestReceived($partnerRequest));

        return back()->with('success', 'Status updated');
    }

    public function respond(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:food_requests,id',
            'status' => 'required|in:accepted,rejected',
        ]);

        $foodRequest = FoodRequest::findOrFail($request->request_id);
        $foodRequest->status = $request->status;
        $foodRequest->save();

        return response()->json(['message' => 'Request response sent']);
    }
}
