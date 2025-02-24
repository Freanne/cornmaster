<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Farm;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Models\User;

class FarmController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'farmer_id' => 'required|exists:farmers,id',
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'area' => 'required|numeric|min:0.1',
    ]);

    $farmer = Farmer::findOrFail($request->farmer_id);

    // Vérifier s'il n'a pas déjà atteint le nombre de parcelles prévu
    if ($farmer->farms()->count() >= $farmer->farm_count) {
        return response()->json([
            'message' => 'Vous avez déjà atteint le nombre de parcelles prévu.'
        ], 400);
    }

    // Création de la parcelle
    $farm = Farm::create([
        'farmer_id' => $farmer->id,
        'name' => $request->name,
        'location' => $request->location,
        'area' => $request->area,
    ]);

    return response()->json($farm, 201);
}


public function index()
{
    $user = Auth::user();

    // Vérifier si l'utilisateur est un agriculteur
    if ($user->user_type !== 'farmer') {
        return response()->json(['message' => 'Accès refusé'], 403);
    }

    // Récupérer les fermes de l'agriculteur connecté
    $farms = Farm::where('farmer_id', $user->id)->get();

    return response()->json($farms);
}

// Récupérer une seule ferme
public function show($id)
{
    $farm = Farm::find($id);

    if (!$farm) {
        return response()->json(['message' => 'Ferme introuvable'], 404);
    }

    return response()->json($farm);
}

public function update(Request $request, $id)
    {
        $farm = Farm::find($id);

        if (!$farm) {
            return response()->json(['message' => 'Ferme introuvable'], 404);
        }

        if ($farm->farmer_id !== Auth::id()) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'area' => 'sometimes|numeric|min:0',
        ]);

        $farm->update($request->only(['name', 'location', 'area']));

        return response()->json(['message' => 'Ferme mise à jour avec succès', 'farm' => $farm]);
    }

    // Supprimer une ferme
    public function destroy($id)
    {
        $farm = Farm::find($id);

        if (!$farm) {
            return response()->json(['message' => 'Ferme introuvable'], 404);
        }

        if ($farm->farmer_id !== Auth::id()) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $farm->delete();

        return response()->json(['message' => 'Ferme supprimée avec succès']);
    }

}
