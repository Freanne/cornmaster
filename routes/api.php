<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DiagnosisController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/videos', [VideoController::class, 'index']); // Liste des vidéos
Route::post('/videos', [VideoController::class, 'store']); // Ajouter une vidéo via un lien
Route::post('/videos/upload', [VideoController::class, 'upload']); // Uploader une vidéo


Route::get('/diagnosis', [DiagnosisController::class, 'index']); // Liste des cartes
// Route::get('/diagnosis/{slug}', [DiagnosisController::class, 'show']); // Détails d'un élément
Route::get('/diagnosis/{id}', [DiagnosisController::class, 'show']);
