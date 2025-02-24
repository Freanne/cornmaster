<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminUserController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs.
     */

    public function index()
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $users = User::all();
        return response()->json($users);
    }

    /**
     * Affiche les détails d'un utilisateur (avec ses relations éventuelles).
     */
    public function show($id)
    {

        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }
        // Vous pouvez adapter les relations si nécessaire (ex. consultations, diagnostics)
        $user = User::with(['consultations', 'diagnostics'])->find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        return response()->json($user);
    }

    /**
     * Met à jour les informations d'un utilisateur.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,'.$user->id,
            // Vous pouvez ajouter d'autres règles de validation si besoin
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Utilisateur mis à jour avec succès',
            'user'    => $user
        ]);
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
