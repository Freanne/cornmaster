<?php

// CropPlanController.php
namespace App\Http\Controllers;

use App\Models\CropPlan;
use App\Models\Farmer;
use Illuminate\Http\Request;

class CropPlanController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'farm_name' => 'required|string|min:3',
            'location' => 'required|string|min:3',
            'maize_variety' => 'required|string',
            'soil_type' => 'required|string',
            'soil_ph' => 'required|string',
            'soil_fertility' => 'required|string',
            'organic_matter' => 'required|boolean',
            'seed_variety' => 'required|string',
            'seed_quantity' => 'required|numeric|min:1',
            'spacing' => 'required|numeric|min:1',
            'irrigation_type' => 'required|string',
            'irrigation_frequency' => 'required|numeric|min:1',
            'fertilizer_type' => 'required|string',
            'fertilizer_quantity' => 'required|numeric|min:1',
            'fertilizer_application' => 'required|string',
            'pesticides' => 'required|string|min:3',
            'start_date' => 'required|date',
            'duration' => 'required|numeric|min:1',
            'workforce' => 'required|numeric|min:1',
            'equipment' => 'nullable|string',
            'disease_history' => 'required|string',
            'pest_control' => 'required|string',
            'harvest_date' => 'required|date',
            'harvest_method' => 'required|string',
            'storage_location' => 'required|string',
            'yield_estimation' => 'required|numeric|min:0',
        ]);

        // Vérifier que le fermier existe et récupérer son ID
        $farmer = Farmer::findOrFail($request->farmer_id);

        // Créer le plan de culture pour ce fermier
        $cropPlan = CropPlan::create([
            'farmer_id' => $farmer->id,
            'farm_name' => $validated['farm_name'],
            'location' => $validated['location'],
            'maize_variety' => $validated['maize_variety'],
            'soil_type' => $validated['soil_type'],
            'soil_ph' => $validated['soil_ph'],
            'soil_fertility' => $validated['soil_fertility'],
            'organic_matter' => $validated['organic_matter'],
            'seed_variety' => $validated['seed_variety'],
            'seed_quantity' => $validated['seed_quantity'],
            'spacing' => $validated['spacing'],
            'irrigation_type' => $validated['irrigation_type'],
            'irrigation_frequency' => $validated['irrigation_frequency'],
            'fertilizer_type' => $validated['fertilizer_type'],
            'fertilizer_quantity' => $validated['fertilizer_quantity'],
            'fertilizer_application' => $validated['fertilizer_application'],
            'pesticides' => $validated['pesticides'],
            'start_date' => $validated['start_date'],
            'duration' => $validated['duration'],
            'workforce' => $validated['workforce'],
            'equipment' => $validated['equipment'],
            'disease_history' => $validated['disease_history'],
            'pest_control' => $validated['pest_control'],
            'harvest_date' => $validated['harvest_date'],
            'harvest_method' => $validated['harvest_method'],
            'storage_location' => $validated['storage_location'],
            'yield_estimation' => $validated['yield_estimation'],
        ]);

        return response()->json($cropPlan, 201);  // Retourner le plan de culture créé
    }
}

