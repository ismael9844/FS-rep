<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partner;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class UploadController extends Controller
{
    /**
     * Affiche la page d'upload pour un utilisateur
     */
    public function showUserUpload($userId)
    {
        $user = User::findOrFail($userId);
        
        // Vérifier que l'utilisateur connecté peut uploader (soit l'utilisateur lui-même, soit un admin)
        if (!Auth::user()->isAdmin() && Auth::id() !== (int)$userId) {
            abort(403, 'Unauthorized to upload documents for this user.');
        }

        return Inertia::render('Upload', [
            'entityType' => 'user',
            'entityId' => (int)$userId,
            'entity' => $user->only(['id', 'name', 'email']),
            'hasDocuments' => !empty($user->document_path)
        ]);
    }

    /**
     * Affiche la page d'upload pour un partenaire
     */
    public function showPartnerUpload($partnerId)
    {
        $partner = Partner::findOrFail($partnerId);
        
        // Vérifier que l'utilisateur connecté peut uploader
        if (!Auth::user()->isAdmin() && $partner->user_id !== Auth::id()) {
            abort(403, 'Unauthorized to upload documents for this partner.');
        }

        return Inertia::render('Upload', [
            'entityType' => 'partner',
            'entityId' => (int)$partnerId,
            'entity' => $partner->only(['id', 'name', 'status']),
            'hasDocuments' => !empty($partner->document_path)
        ]);
    }

    /**
     * Upload de document pour un utilisateur
     */
    public function uploadUserDocument(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        // Vérification des permissions
        if (!Auth::user()->isAdmin() && Auth::id() !== (int)$userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validation
        $request->validate([
            'document' => [
                'required',
                'file',
                File::types(['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])
                    ->max(10 * 1024), // 10MB max
            ]
        ]);

        try {
            // Supprimer l'ancien document s'il existe
            if ($user->document_path && Storage::disk('public')->exists($user->document_path)) {
                Storage::disk('public')->delete($user->document_path);
            }

            // Créer le dossier de destination
            $folder = 'documents/users/' . $userId;
            
            // Générer un nom de fichier unique
            $originalName = $request->file('document')->getClientOriginalName();
            $extension = $request->file('document')->getClientOriginalExtension();
            $fileName = time() . '_' . str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
            
            // Stocker le fichier
            $path = $request->file('document')->storeAs($folder, $fileName, 'public');

            // Mettre à jour la colonne document_path de l'utilisateur
            $user->update([
                'document_path' => $path
            ]);

            // Marquer les demandes de documents comme complétées si elles existent
            if (class_exists('App\Models\DocumentRequest')) {
                DocumentRequest::where('user_id', $userId)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'completed',
                        'completed_at' => now()
                    ]);
            }

            return response()->json([
                'message' => 'Document uploaded successfully!',
                'document_path' => $path,
                'success' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Document upload failed for user ' . $userId, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Upload failed: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    /**
     * Upload de document pour un partenaire
     */
    public function uploadPartnerDocument(Request $request, $partnerId)
    {
        $partner = Partner::findOrFail($partnerId);
        
        // Vérification des permissions
        if (!Auth::user()->isAdmin() && $partner->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validation
        $request->validate([
            'document' => [
                'required',
                'file',
                File::types(['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])
                    ->max(10 * 1024), // 10MB max
            ]
        ]);

        try {
            // Supprimer l'ancien document s'il existe
            if ($partner->document_path && Storage::disk('public')->exists($partner->document_path)) {
                Storage::disk('public')->delete($partner->document_path);
            }

            // Créer le dossier de destination
            $folder = 'documents/partners/' . $partnerId;
            
            // Générer un nom de fichier unique
            $originalName = $request->file('document')->getClientOriginalName();
            $extension = $request->file('document')->getClientOriginalExtension();
            $fileName = time() . '_' . str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
            
            // Stocker le fichier
            $path = $request->file('document')->storeAs($folder, $fileName, 'public');

            // Mettre à jour la colonne document_path du partenaire
            $partner->update([
                'document_path' => $path
            ]);

            // Marquer les demandes de documents comme complétées si elles existent
            if (class_exists('App\Models\DocumentRequest')) {
                DocumentRequest::where('partner_id', $partnerId)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'completed',
                        'completed_at' => now()
                    ]);
            }

            return response()->json([
                'message' => 'Document uploaded successfully!',
                'document_path' => $path,
                'success' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Document upload failed for partner ' . $partnerId, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Upload failed: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    /**
     * Télécharger un document
     */
    public function downloadDocument(Request $request, $type, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only admins can download documents');
        }

        $entity = null;
        $documentPath = null;

        if ($type === 'user') {
            $entity = User::findOrFail($id);
            $documentPath = $entity->document_path;
        } elseif ($type === 'partner') {
            $entity = Partner::findOrFail($id);
            $documentPath = $entity->document_path;
        } else {
            abort(400, 'Invalid entity type');
        }

        if (!$documentPath || !Storage::disk('public')->exists($documentPath)) {
            abort(404, 'Document not found');
        }

        return Storage::disk('public')->download($documentPath);
    }

    /**
     * Supprimer un document
     */
    public function deleteDocument(Request $request, $type, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only admins can delete documents');
        }

        $entity = null;

        if ($type === 'user') {
            $entity = User::findOrFail($id);
        } elseif ($type === 'partner') {
            $entity = Partner::findOrFail($id);
        } else {
            abort(400, 'Invalid entity type');
        }

        if ($entity->document_path && Storage::disk('public')->exists($entity->document_path)) {
            Storage::disk('public')->delete($entity->document_path);
        }

        $entity->update([
            'document_path' => null
        ]);

        return response()->json([
            'message' => 'Document deleted successfully',
            'success' => true
        ]);
    }

    /**
     * Lister les demandes de documents en attente
     */
    public function listPendingRequests()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $requests = DocumentRequest::with(['user', 'partner', 'admin'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/DocumentRequests', [
            'requests' => $requests
        ]);
    }
}