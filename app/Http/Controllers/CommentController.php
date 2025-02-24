<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Diagnostic;
class CommentController extends Controller
{
    //

    public function addComment(Request $request)
{
    // Validation des données
    $request->validate([
        'diagnostic_id' => 'required|exists:diagnostics,id',
        'expert_id' => 'required|exists:experts,id',
        'comment' => 'required|string',
    ]);

    try {
        // Création du commentaire
        $comment = Comment::create([
            'diagnostic_id' => $request->diagnostic_id,
            'expert_id' => $request->expert_id,
            'comment' => $request->comment,
        ]);

        return response()->json($comment, 201); // Si tout va bien, retour du commentaire créé
    } catch (\Exception $e) {
        // Gestion des erreurs en cas d'échec
        return response()->json(['error' => 'Commentaire non créé', 'message' => $e->getMessage()], 400);
    }
}




    public function getCommentsByDiagnostic($diagnostic_id)
    {
        $comments = Comment::where('diagnostic_id', $diagnostic_id)->with('expert')->get();
        return response()->json($comments);
    }


}
