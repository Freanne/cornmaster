<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }

    public function update(Request $request)
{
    $user = $request->user();

    // Validation des données
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        // Ajoute d'autres champs selon tes besoins
    ]);

    // Mise à jour des informations de l'utilisateur
    $user->update($request->only(['first_name', 'last_name', 'email']));

    return response()->json(['message' => 'Informations mises à jour avec succès.']);
}


public function destroy(Request $request)
{
    $user = $request->user();
    
    // Suppression de l'utilisateur
    $user->delete();

    return response()->json(['message' => 'Utilisateur supprimé avec succès.']);
}
}
