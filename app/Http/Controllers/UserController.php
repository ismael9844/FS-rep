<?php

namespace App\Http\Controllers;

use App\Models\User;       
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }
    public function uploadRequestDocument(Request $request, $id)
{
    $request->validate([
        'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $path = $request->file('document')->store('documents');

    // Déterminer le type d'entité pour mettre à jour le bon model
    if ($request->is('users/*')) {
        $entity = User::findOrFail($id);
    } else {
        $entity = Partner::findOrFail($id);
    }

    $entity->update(['document_path' => $path]);

    // Optionnel : notifier l'admin
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        $admin->notify(new \App\Notifications\DocumentUploaded($entity));
    }

    return back()->with('success', 'Document uploaded successfully.');
}

}
