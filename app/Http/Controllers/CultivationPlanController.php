<?php

namespace App\Http\Controllers;

use App\Models\CultivationPlan;
use App\Models\Farm;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CultivationPlanController extends Controller
{

    public function store(Request $request, $farm_id)
{
    $request->validate([
        'maize_variety' => 'required|string',
        'soil_type' => 'required|string',
        'season_type' => 'required|string',
        'irrigation_method' => 'required|string',
        'fertilizer_type' => 'required|string',
        'sowing_date' => 'required|date',
    ]);

    $farm = Farm::findOrFail($farm_id);
    // dd($farm->id);
    // Vérifier si un plan existe déjà pour cette ferme
    if ($farm->cultivationPlan()->exists()) {
        return response()->json(['message' => 'Cette parcelle a déjà un plan de culture.'], 400);
    }

    // Calcul des dates
    $sowingDate = Carbon::parse($request->sowing_date);
    $harvestDate = $sowingDate->copy()->addDays(90);

    // Création du plan de culture
    $plan = CultivationPlan::create([
        'farm_id' => $farm_id,
        'maize_variety' => $request->maize_variety,
        'soil_type' => $request->soil_type,
        'season_type' => $request->season_type,
        'irrigation_method' => $request->irrigation_method,
        'fertilizer_type' => $request->fertilizer_type,
        'sowing_date' => $sowingDate,
        'harvest_date' => $harvestDate
    ]);
    // dd($plan);
    // Planification des tâches associées
    $this->scheduleTasks($plan, $sowingDate);

    return response()->json($plan, 201);
    // dd($request->all());
}



    public function show($farm_id)
    {
        $plan = CultivationPlan::where('farm_id', $farm_id)->first();
        if (!$plan) {
            return response()->json(['message' => 'Aucun plan de culture trouvé pour cette parcelle.'], 404);
        }
        return response()->json($plan);
    }

    public function update(Request $request, $id)
    {
        $plan = CultivationPlan::findOrFail($id);
        $plan->update($request->all());
        return response()->json($plan);
    }

    public function destroy($id)
    {
        $plan = CultivationPlan::findOrFail($id);
        $plan->delete();
        return response()->json(['message' => 'Plan de culture supprimé avec succès.']);
    }


    private function scheduleTasks(CultivationPlan $plan, Carbon $sowingDate)
    {
        for ($i = 1; $i <= 12; $i++) { 
            Task::create([
                'cultivation_plan_id' => $plan->id,
                'task_type' => 'irrigation',
                'task_date' => $sowingDate->copy()->addDays($i * 7),
            ]);
        }

        Task::create([
            'cultivation_plan_id' => $plan->id,
            'task_type' => 'fertilizer',
            'task_date' => $sowingDate->copy()->addDays(30),
        ]);

        Task::create([
            'cultivation_plan_id' => $plan->id,
            'task_type' => 'fertilizer',
            'task_date' => $sowingDate->copy()->addDays(60),
        ]);

        Task::create([
            'cultivation_plan_id' => $plan->id,
            'task_type' => 'harvest',
            'task_date' => $sowingDate->copy()->addDays(90),
        ]);
    }

}