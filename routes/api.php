<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/videos', [VideoController::class, 'index']); // Liste des vidéos
Route::post('/videos', [VideoController::class, 'store']); // Ajouter une vidéo via un lien
Route::post('/videos/upload', [VideoController::class, 'upload']); // Uploader une vidéo