<?php

namespace App\Http\Controllers;

use App\Models\CultivationPlan;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function updateTaskStatus(Request $request, $task_id)
    {
        // Validation
        $request->validate([
            'status' => 'required|in:en attente,en cours,terminée'
        ]);

        // Trouver la tâche
        $task = Task::findOrFail($task_id);

        // Mise à jour du statut
        $task->status = $request->status;
        $task->save();

        // Retourner la tâche mise à jour
        return response()->json([
            'message' => 'Statut de la tâche mis à jour.',
            'task' => $task
        ], 200);
    }

    public function getTasksForPlan($plan_id)
{
    $tasks = Task::where('cultivation_plan_id', $plan_id)
                 ->orderBy('task_date', 'asc')
                 ->get();

    if ($tasks->isEmpty()) {
        return response()->json(['message' => 'Aucune tâche trouvée pour ce plan de culture.'], 404);
    }

    return response()->json($tasks, 200);
}
}