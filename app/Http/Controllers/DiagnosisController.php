<?php

// namespace App\Http\Controllers;

// use App\Models\Diagnosis;
// use Illuminate\Http\Request;

// class DiagnosisController extends Controller
// {
//     public function index()
//         {
//             return response()->json(Diagnosis::select('id', 'name', 'description', 'slug', 'pathogene' ,'image_url')->get());
//         }

//     public function show($id)
//     {
//     $diagnosis = Diagnosis::find($id);

//     if (!$diagnosis) {
//         return response()->json(['message' => 'Disease not found'], 404);
//     }

//     return response()->json($diagnosis);
// }
// }



namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    /**
     * Liste toutes les maladies (accessible à tous)
     */
    public function index()
    {
        return response()->json(Diagnosis::select('id', 'name', 'description', 'slug', 'pathogene', 'image_url')->get());
    }

    /**
     * Affiche les détails d'une maladie (accessible à tous)
     */
    public function show($id)
    {
        $diagnosis = Diagnosis::find($id);

        if (!$diagnosis) {
            return response()->json(['message' => 'Maladie non trouvée'], 404);
        }

        return response()->json($diagnosis);
    }

    /**
     * Ajoute une nouvelle maladie (réservé à l'admin)
     */
    public function store(Request $request)
    {
        // Vérifie si l'utilisateur est admin
        if (!Auth::user() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        // Validation des données
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'pathogene'   => 'required|string',
            'prevention'  => 'required|string',
            'image_url'   => 'required|json', // Doit être un JSON
        ]);

        // Création de la maladie
        $diagnosis = Diagnosis::create($validated);

        return response()->json([
            'message'   => 'Maladie ajoutée avec succès',
            'diagnosis' => $diagnosis
        ], 201);
    }

    /**
     * Met à jour une maladie (réservé à l'admin)
     */
    public function update(Request $request, $id)
    {
        // Vérifie si l'utilisateur est admin
        if (!Auth::user() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $diagnosis = Diagnosis::find($id);
        if (!$diagnosis) {
            return response()->json(['message' => 'Maladie non trouvée'], 404);
        }

        // Validation des données
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'pathogene'   => 'sometimes|string',
            'prevention'  => 'sometimes|string',
            'image_url'   => 'sometimes|json', // Optionnel mais doit être un JSON valide
        ]);

        // Mise à jour
        $diagnosis->update($validated);

        return response()->json([
            'message'   => 'Maladie mise à jour avec succès',
            'diagnosis' => $diagnosis
        ]);
    }

    /**
     * Supprime une maladie (réservé à l'admin)
     */
    public function destroy($id)
    {
        // Vérifie si l'utilisateur est admin
        if (!Auth::user() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $diagnosis = Diagnosis::find($id);
        if (!$diagnosis) {
            return response()->json(['message' => 'Maladie non trouvée'], 404);
        }

        $diagnosis->delete();

        return response()->json(['message' => 'Maladie supprimée avec succès']);
    }
}
