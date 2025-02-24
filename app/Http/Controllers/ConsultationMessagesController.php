<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationMessages;
use App\Models\User;
use Illuminate\Http\Request;

class ConsultationMessagesController extends Controller
{
    // Récupérer les messages d'une consultation
    public function getMessages($consultationId)
    {
        $messages = ConsultationMessages::where('consultation_id', $consultationId)
                                        ->orderBy('created_at', 'asc')
                                        ->with('sender', 'receiver') // Charger les informations de l'expéditeur et du destinataire
                                        ->get();

        return response()->json($messages);
    }

    // Envoyer un message dans une consultation
    public function sendMessage(Request $request, $consultationId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $consultation = Consultation::findOrFail($consultationId);

        // Vérifier que l'utilisateur a le droit d'envoyer un message
        $user = auth()->user();
        if ($user->id !== $consultation->farmer_id && $user->id !== $consultation->expert_id) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Déterminer le type d'expéditeur (agriculteur ou expert)
        $senderType = ($user->id === $consultation->farmer_id) ? 'farmer' : 'expert';

        // Créer le message
        $message = ConsultationMessages::create([
            'consultation_id' => $consultationId,
            'sender_id' => $user->id,
            'receiver_id' => ($senderType === 'farmer') ? $consultation->expert_id : $consultation->farmer_id,
            'message' => $request->message,
            'sender_type' => $senderType,
        ]);

        return response()->json($message, 201);
    }

    // Récupérer les agriculteurs ayant participé à des consultations avec un expert
    public function getFarmersByExpert($expertId)
    {
        $consultationIds = Consultation::where('expert_id', $expertId)->pluck('id');
        $farmerIds = ConsultationMessages::whereIn('consultation_id', $consultationIds)
                                         ->distinct()
                                         ->pluck('sender_id');
        $farmers = User::whereIn('id', $farmerIds)->where('user_type', 'farmer')->get();

        return response()->json($farmers);
    }

    // Récupérer les messages envoyés par un agriculteur dans une consultation
    public function getMessagesByFarmer($consultationId, $farmerId)
    {
        $messages = ConsultationMessages::where('consultation_id', $consultationId)
                                       ->where('sender_id', $farmerId)
                                       ->with('sender', 'receiver')
                                       ->get();

        return response()->json($messages);
    }

    // Récupérer les messages entre un agriculteur et un expert dans une consultation
    public function getMessagesByFarmerAndExpert($consultationId, $farmerId)
    {
        $user = auth()->user();
        $consultation = Consultation::findOrFail($consultationId);

        if ($user->id !== $consultation->farmer_id && $user->id !== $consultation->expert_id) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $messages = ConsultationMessages::where('consultation_id', $consultationId)
                                        ->where('sender_id', $farmerId)
                                        ->orWhere('sender_id', $consultation->expert_id)
                                        ->get();

        return response()->json($messages);
    }

    public function getConsultationsByFarmer($farmerId)
{
    $consultations = Consultation::where('farmer_id', $farmerId)->get();

    if ($consultations->isEmpty()) {
        return response()->json(['message' => 'Aucune consultation trouvée'], 404);
    }

    return response()->json($consultations);
}

public function getConsultationByFarmerAndExpert($farmerId, $expertId)
{
    $consultation = Consultation::where('farmer_id', $farmerId)
        ->where('expert_id', $expertId)
        ->first();

    if (!$consultation) {
        return response()->json(['message' => 'Aucune consultation trouvée entre cet agriculteur et cet expert'], 404);
    }

    return response()->json($consultation);
}
}



































// namespace App\Http\Controllers;
// use App\Models\User;
// use App\Models\Consultation;
// use App\Models\ConsultationMessages;
// use Illuminate\Http\Request;

// class ConsultationMessagesController extends Controller
// {
//     // Récupérer les messages d'une consultation
//     public function getMessages($consultationId)
//     {
//         $messages = ConsultationMessages::where('consultation_id', $consultationId)
//                                         ->orderBy('created_at', 'asc')
//                                         ->get();

//         return response()->json($messages);
//     }

//     // Envoyer un message dans une consultation
//     public function sendMessage(Request $request, $consultationId)
//     {
//         $request->validate([
//             'message' => 'required|string',
//         ]);

//         $consultation = Consultation::findOrFail($consultationId);

//         // Vérifier que l'utilisateur a le droit d'envoyer un message (ex: l'agriculteur ou l'expert)
//         $user = auth()->user();
//         if ($user->id !== $consultation->farmer_id && $user->id !== $consultation->expert_id) {
//             return response()->json(['error' => 'Non autorisé'], 403);
//         }

//         // Créer un message
//         $message = ConsultationMessages::create([
//             'consultation_id' => $consultationId,
//             'sender_id' => $user->id,
//             'message' => $request->message,
//             'sender_type' => $user->user_type, // Vérifie que ton modèle User contient bien un champ 'role'
//         ]);

//         return response()->json($message, 201);
//     }

//     public function getFarmersByExpert($expertId)
// {
//     // Récupérer les consultations gérées par cet expert
//     $consultationIds = Consultation::where('expert_id', $expertId)->pluck('id');

//     // Récupérer les IDs uniques des agriculteurs ayant envoyé au moins un message dans ces consultations
//     $farmerIds = ConsultationMessages::whereIn('consultation_id', $consultationIds)
//                                     ->distinct()
//                                     ->pluck('sender_id');

//     // Récupérer les agriculteurs correspondants
//     $farmers = User::whereIn('id', $farmerIds)
//                    ->where('user_type', 'farmer')
//                    ->get();

//     return response()->json($farmers);
// }

// public function getMessagesByFarmer($consultationId, $farmerId)
// {
//     // Récupérer tous les messages envoyés par l'agriculteur dans cette consultation
//     $messages = ConsultationMessages::where('consultation_id', $consultationId)
//                                    ->where('sender_id', $farmerId)
//                                    ->get();

//     // Retourner les messages sous forme de réponse JSON
//     return response()->json($messages);
// }

// public function getMessagesByFarmerAndExpert($consultationId, $farmerId)
// {
//     $user = auth()->user();
    
//     // Vérifier que l'utilisateur est soit le fermier, soit l'expert de la consultation
//     $consultation = Consultation::findOrFail($consultationId);
//     if ($user->id !== $consultation->farmer_id && $user->id !== $consultation->expert_id) {
//         return response()->json(['error' => 'Non autorisé'], 403);
//     }

//     // Récupérer les messages envoyés par le fermier
//     $messages = ConsultationMessages::where('consultation_id', $consultationId)
//                                     ->where('sender_id', $farmerId)
//                                     ->get();

//     return response()->json($messages);
// }


// }




