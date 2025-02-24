<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Liste toutes les vidéos (accessible à tous)
     */
    public function index()
    {
        $videos = Video::paginate(10);

        return response()->json([
            'videos' => $videos,
        ]);
    }

    /**
     * Ajouter une vidéo via un lien (réservé à l'admin)
     */
    public function store(Request $request)
    {
        if (!Auth::user() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'link'        => 'required|url',
            'description' => 'required|string',
            'step'        => 'required|string',
        ]);

        $video = Video::create($request->all());

        return response()->json([
            'message' => 'Vidéo ajoutée avec succès',
            'video'   => $video,
        ], 201);
    }

    /**
     * Upload et stocke une vidéo (réservé à l'admin)
     */
    public function upload(Request $request)
    {
        if (!Auth::user() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'step'        => 'required|string',
            'video'       => 'required|file|mimes:mp4,mov,avi,wmv|max:20480', // 20 Mo max
        ]);

        // Stockage de la vidéo
        $path = $request->file('video')->store('videos', 'public');

        $video = Video::create([
            'title'       => $request->title,
            'description' => $request->description,
            'step'        => $request->step,
            'link'        => $path, // Stocke le chemin vers la vidéo
        ]);

        return response()->json([
            'message' => 'Vidéo ajoutée avec succès',
            'video'   => $video,
        ], 201);
    }

    /**
     * Modifier une vidéo (réservé à l'admin)
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $video = Video::find($id);
        if (!$video) {
            return response()->json(['message' => 'Vidéo non trouvée'], 404);
        }

        $request->validate([
            'title'       => 'sometimes|string|max:255',
            'link'        => 'sometimes|url',
            'description' => 'sometimes|string',
            'step'        => 'sometimes|string',
        ]);

        $video->update($request->all());

        return response()->json([
            'message' => 'Vidéo mise à jour avec succès',
            'video'   => $video,
        ]);
    }

    /**
     * Supprimer une vidéo (réservé à l'admin)
     */
    public function destroy($id)
    {
        if (!Auth::user() || Auth::user()->user_type !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $video = Video::find($id);
        if (!$video) {
            return response()->json(['message' => 'Vidéo non trouvée'], 404);
        }

        // Supprimer le fichier vidéo du stockage si c'est un fichier local
        if (!filter_var($video->link, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($video->link);
        }

        $video->delete();

        return response()->json(['message' => 'Vidéo supprimée avec succès']);
    }
}



// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Video;

// class VideoController extends Controller
// {
//     public function store(Request $request)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'link' => 'required|url',
//             'description' => 'required|string',
//             'step' => 'required|string',
//         ]);

//         $video = Video::create($request->all());

//         return response()->json([
//             'message' => 'Vidéo ajoutée avec succès',
//             'video' => $video,
//         ], 201);
//     }

//     public function upload(Request $request)
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'required|string',
//         'step' => 'required|string',
//         'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:20480', // Limite de 20 Mo
//     ]);

//     // Stockage de la vidéo
//     $path = $request->file('video')->store('videos', 'public');

//     // Création de la vidéo dans la base de données
//     $video = Video::create([
//         'title' => $request->title,
//         'description' => $request->description,
//         'step' => $request->step,
//         'link' => $path, // Stocke le chemin vers la vidéo
//     ]);

//     return response()->json([
//         'message' => 'Vidéo ajoutée avec succès',
//         'video' => $video,
//     ], 201);
// }
//     // Lire toutes les vidéos
//     public function index()
//     {
//         $videos = Video::paginate(10); // Paginer les résultats (10 vidéos par page)

//         return response()->json([
//             'videos' => $videos,
//         ]);
//     }
// }
