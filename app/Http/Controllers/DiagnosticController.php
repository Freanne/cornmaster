<?php

namespace App\Http\Controllers;
use App\Models\Diagnostic;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farmer;

class DiagnosticController extends Controller
{
    //


    public function create(Request $request)
    {
        $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'expert_id' => 'required|exists:experts,id',
            'description' => 'required',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $request->file('image')->store('diagnostics', 'public');
        
        $diagnostic = Diagnostic::create([
            'farmer_id' => $request->farmer_id,
            'expert_id' => $request->expert_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
        
        $diagnostic->load('expert', 'expert.user');
        $diagnostic->image = asset('storage/' . $imagePath);
        return response()->json($diagnostic, 201);
    }

    public function indexByFarmer($farmer_id)
{
    $diagnostics = Diagnostic::where('farmer_id', $farmer_id)
        ->with('expert', 'expert.user') // Charger l'expert et ses informations utilisateur (nom, prénom)
        ->get();

    // Ajouter l'URL de l'image pour chaque diagnostic
    $diagnostics->each(function ($diagnostic) {
        $diagnostic->image_url = asset('storage/' . $diagnostic->image);
    });

    return response()->json($diagnostics);
}

public function indexByExpert($expert_id)
{
    $diagnostics = Diagnostic::where('expert_id', $expert_id)
        ->with('farmer', 'farmer.user') // Charger le fermier et ses informations utilisateur (nom, prénom)
        ->get();

    // Ajouter l'URL de l'image pour chaque diagnostic
    $diagnostics->each(function ($diagnostic) {
        $diagnostic->image_url = asset('storage/' . $diagnostic->image);
    });

    return response()->json($diagnostics);
}

    public function getAllDiagnostics()
{
    $diagnostics = Diagnostic::all();
    return response()->json($diagnostics);
}


}
