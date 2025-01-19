<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'description' => 'required|string',
            'step' => 'required|string',
        ]);

        $video = Video::create($request->all());

        return response()->json([
            'message' => 'Vidéo ajoutée avec succès',
            'video' => $video,
        ], 201);
    }

    public function upload(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'step' => 'required|string',
        'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:20480', // Limite de 20 Mo
    ]);

    // Stockage de la vidéo
    $path = $request->file('video')->store('videos', 'public');

    // Création de la vidéo dans la base de données
    $video = Video::create([
        'title' => $request->title,
        'description' => $request->description,
        'step' => $request->step,
        'link' => $path, // Stocke le chemin vers la vidéo
    ]);

    return response()->json([
        'message' => 'Vidéo ajoutée avec succès',
        'video' => $video,
    ], 201);
}
    // Lire toutes les vidéos
    public function index()
    {
        $videos = Video::paginate(10); // Paginer les résultats (10 vidéos par page)

        return response()->json([
            'videos' => $videos,
        ]);
    }
}
