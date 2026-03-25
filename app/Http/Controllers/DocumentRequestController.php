<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Partner;
use App\Notifications\DocumentRequestMail;

class DocumentRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:user,partner',
            'id'   => 'required|integer',
            'note' => 'nullable|string|max:1000',
        ]);

        $type = $request->type;
        $id = $request->id;
        $note = $request->note;

        $token = Str::random(48);
        $expires = Carbon::now()->addDays(7);

        if ($type === 'user') {
            $model = User::findOrFail($id);
            $model->document_request_token = $token;
            $model->document_request_expires_at = $expires;
            $model->save();

            // notifier directement l'utilisateur
            $model->notify(new DocumentRequestMail($model, $token, $note));
        } else {
            $partner = Partner::findOrFail($id);
            $partner->document_request_token = $token;
            $partner->document_request_expires_at = $expires;
            $partner->save();

            // on suppose partner->user existe, sinon adapte: utiliser partner->email
            if ($partner->user) {
                $partner->user->notify(new DocumentRequestMail($partner, $token, $note));
            }
        }

        return ;
    }
}
