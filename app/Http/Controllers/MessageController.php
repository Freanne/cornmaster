<?php

// app/Http/Controllers/MessageController.php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Consultation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Envoyer un message dans une consultation
    public function sendMessage(Request $request, $consultationId)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $consultation = Consultation::findOrFail($consultationId);

        $message = Message::create([
            'consultation_id' => $consultationId,
            'sender_id' => $validated['sender_id'],
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['message'],
        ]);

        return response()->json($message, 201);
    }

    // Obtenir les messages d'une consultation
    public function getMessages($consultationId)
    {
        $consultation = Consultation::findOrFail($consultationId);
        $messages = $consultation->messages()->with('sender', 'receiver')->get();

        return response()->json($messages);
    }
}
