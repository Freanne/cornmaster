<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ConsultationMessagesController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CropPlanController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FarmController;

use App\Http\Controllers\CultivationPlanController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminUserController;
// Route::get('/csrf-token', function () {
//     return response()->json(['csrfToken' => csrf_token()]);
// });

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/admin/users', [AdminUserController::class, 'index']);
    Route::get('/admin/users/{id}', [AdminUserController::class, 'show']);
    Route::put('/admin/users/{id}', [AdminUserController::class, 'update']);
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy']);

    Route::post('/diseases', [DiagnosisController::class, 'store']); // Admin only
    Route::put('/diseases/{id}', [DiagnosisController::class, 'update']); // Admin only
    Route::delete('/diseases/{id}', [DiagnosisController::class, 'destroy']); // Admin only

    Route::post('/videos', [VideoController::class, 'store']); // Admin only
    Route::post('/videos/upload', [VideoController::class, 'upload']); // Admin only
    Route::put('/videos/{id}', [VideoController::class, 'update']); // Admin only
    Route::delete('/videos/{id}', [VideoController::class, 'destroy']); // Admin only
    
    // Afficher les informations de l'utilisateur
    Route::get('/user', [UserController::class, 'show']);

    // Mettre à jour les informations de l'utilisateur
    Route::put('/user', [UserController::class, 'update']);

    // Supprimer l'utilisateur
    Route::delete('/user', [UserController::class, 'destroy']);

        // Création d'une consultation
        Route::post('/consultations', [ConsultationController::class, 'create']);
    
        Route::post('/consultations', [ConsultationController::class, 'create']); // Créer une consultation
        Route::get('/consultations/farmer/{farmerId}', [ConsultationController::class, 'getFarmerConsultations']); // Consulter les consultations de l'agriculteur
        Route::get('/consultations/expert/{expertId}', [ConsultationController::class, 'getExpertConsultations']); 

// Récupérer les messages d'une consultation
Route::get('/consultations/{consultationId}/messages', [ConsultationMessagesController::class, 'getMessages']);

// Envoyer un message dans une consultation
Route::post('/consultations/{consultationId}/messages', [ConsultationMessagesController::class, 'sendMessage']);

// Récupérer les agriculteurs associés à un expert
Route::get('/experts/{expertId}/farmers', [ConsultationMessagesController::class, 'getFarmersByExpert']);

// Récupérer les messages envoyés par un agriculteur dans une consultation
Route::get('/consultations/{consultationId}/messages/farmer/{farmerId}', [ConsultationMessagesController::class, 'getMessagesByFarmer']);

// Récupérer les messages entre un agriculteur et un expert dans une consultation
Route::get('/consultations/{consultationId}/messages/farmer/{farmerId}/expert', [ConsultationMessagesController::class, 'getMessagesByFarmerAndExpert']);
Route::get('/farmers/{farmerId}/consultations', [ConsultationMessagesController::class, 'getConsultationsByFarmer']);
Route::get('/farmers/{farmerId}/consultations/expert/{expertId}', [ConsultationMessagesController::class, 'getConsultationByFarmerAndExpert']);
        // // Consultation des consultations par agriculteur
        // Route::get('/consultations/farmer/{farmerId}', [ConsultationController::class, 'getFarmerConsultations']);
        
        // // Consultation des consultations par expert
        // Route::get('/consultations/expert/{expertId}', [ConsultationController::class, 'getExpertConsultations']);
        
        // // Envoi d'un message

        // Route::get('/consultation/{consultationId}/messages/farmer/{farmerId}', [ConsultationMessagesController::class, 'getMessagesByFarmerAndExpert']);
        // Route::get('/consultations/{consultationId}/messages', [ConsultationMessagesController::class, 'getMessages']);
        // Route::post('/consultations/{consultationId}/messages', [ConsultationMessagesController::class, 'sendMessage']);

        // Route:: post('/messages/{consultationId}', [MessageController::class, 'sendMessage']);
        
        // // Récupération des messages d'une consultation
        // Route::get('/messages/{consultationId}', [MessageController::class, 'getMessages']);
        // Route::get('/consultations/{expertId}/farmers', [ConsultationMessagesController::class, 'getFarmersByExpert']);
        // Route::post('/diagnostics', [DiagnosticController::class, 'store']);
       
        // Route::post('/diagnostics/{id}/comment', [CommentController::class, 'store']);

        Route::post('/diagnostics/create', [DiagnosticController::class, 'create']);
        Route::get('diagnostics/farmer/{farmer_id}', [DiagnosticController::class, 'indexByFarmer']);
        Route::get('diagnostics/expert/{expert_id}', [DiagnosticController::class, 'indexByExpert']);
        Route::post('comments/add', [CommentController::class, 'addComment']);
        Route::get('comments/diagnostic/{diagnostic_id}', [CommentController::class, 'getCommentsByDiagnostic']);


        Route::post('/farms', [FarmController::class, 'store']);
        Route::get('/farms', [FarmController::class, 'index']); // Récupérer toutes les fermes
        Route::get('/farms/{id}', [FarmController::class, 'show']); 
        Route::put('/farms/{id}', [FarmController::class, 'update']); // Modifier une ferme
        Route::delete('/farms/{id}', [FarmController::class, 'destroy']);

        // Route::prefix('farms/{farm_id}/cultivation-plan')->group(function () {
        //     Route::post('/', [CultivationPlanController::class, 'store']); // Créer un plan de culture
        //     Route::get('/', [CultivationPlanController::class, 'show']); // Afficher un plan de culture d'une ferme
        // });
        
        // Route::prefix('cultivation-plan')->group(function () {
        //     Route::put('/{id}', [CultivationPlanController::class, 'update']); // Mettre à jour un plan de culture
        //     Route::delete('/{id}', [CultivationPlanController::class, 'destroy']); // Supprimer un plan de culture
        // });

        Route::post('/cultivation-plans/{farm_id}', [CultivationPlanController::class, 'store']);
        Route::get('/cultivation-plans/{farm_id}', [CultivationPlanController::class, 'show']);
        Route::put('/cultivation-plan/{id}', [CultivationPlanController::class, 'update']);
        Route::delete('/cultivation-plan/{id}', [CultivationPlanController::class, 'destroy']);


        Route::get('/cultivation-plans/{plan_id}/tasks', [TaskController::class, 'getTasksForPlan']);
        Route::put('/tasks/{task_id}/status', [TaskController::class, 'updateTaskStatus']);
        
    });


    // Route::get('/diagnostics/expert/{id}', [DiagnosticController::class, 'getForExpert']);


Route::post('/crop-plans', [CropPlanController::class, 'store']);

Route::middleware('web')->get('/custom-csrf-cookie', function () {
    return response()->json(['message' => 'CSRF Cookie Set']);
});

Route::get('/videos', [VideoController::class, 'index']); // Liste des vidéos
Route::post('/videos', [VideoController::class, 'store']); // Ajouter une vidéo via un lien
Route::post('/videos/upload', [VideoController::class, 'upload']); // Uploader une vidéo


Route::get('/diagnosis', [DiagnosisController::class, 'index']); // Liste des cartes
// Route::get('/diagnosis/{slug}', [DiagnosisController::class, 'show']); // Détails d'un élément
Route::get('/diagnosis/{id}', [DiagnosisController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/experts', [ExpertController::class, 'index']);
Route::get('/experts/{id}', [ExpertController::class, 'show']);


// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::get('/admin/users', [AdminUserController::class, 'index']);
//     Route::get('/users/{id}', [AdminUserController::class, 'show']);
//     Route::put('/users/{id}', [AdminUserController::class, 'update']);
//     Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);
// });

Route::get('/test-admin', [AdminUserController::class, 'index'])->middleware('admin');