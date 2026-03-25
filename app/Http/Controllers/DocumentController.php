<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Partner;
use App\Models\User as AppUser;
use App\Notifications\DocumentUploaded;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Show the upload form (from email link)
    public function showUploadForm($token)
    {
        return inertia('Documents/Upload', [
            'token' => $token
        ]);
    }

    // Handle file upload
    public function uploadWithToken(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'token' => 'required'
        ]);

        $token = $request->token;

        // Find user or partner by token
        $model = User::where('document_request_token', $token)->first();
        if (!$model) {
            $model = Partner::where('document_request_token', $token)->first();
        }

        if (!$model) {
            return back()->withErrors(['token' => 'Invalid or already used link']);
        }

        // Check expiration
        if ($model->document_request_expires_at && Carbon::now()->greaterThan($model->document_request_expires_at)) {
            return back()->withErrors(['token' => 'This link has expired']);
        }

        // Store file
        $path = $request->file('document')->store('documents', 'public');

        // Save in document_path and invalidate token
        $model->document_path = $path;
        $model->document_request_token = null;
        $model->document_request_expires_at = null;
        $model->save();

        // Notify all admins
        $admins = AppUser::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DocumentUploaded($model, $path));
        }

        return back()->with('success', 'Document uploaded successfully ✅');
    }

    // Alias for store()
    public function store(Request $request)
    {
        return $this->uploadWithToken($request);
    }
}
