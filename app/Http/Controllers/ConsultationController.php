<?php


// app/Http/Controllers/ConsultationController.php
// namespace App\Http\Controllers;

// use App\Models\Consultation;
// use App\Models\ConsultationMessages;
// use App\Models\User;
// use Illuminate\Http\Request;

// class ConsultationController extends Controller
// {
//     // Créer une consultation
//     public function create(Request $request)
//     {
//         $validated = $request->validate([
//             'expert_id' => 'required|exists:experts,id',
//             'message' => 'required|string',
//             'farmer_id' => 'required|exists:users,id', // Changer de 'farmers' à 'users'
//         ]);
    
//         // Créer une consultation
//         $consultation = Consultation::create([
//             'expert_id' => $validated['expert_id'],
//             'farmer_id' => $validated['farmer_id'],
//             'status' => 'pending', // Initialement en attente
//         ]);
    
//         // Créer un message associé à cette consultation
//         $message = ConsultationMessages::create([
//             'consultation_id' => $consultation->id,
//             'sender_id' => $validated['farmer_id'],  // L'agriculteur envoie le premier message
//             'message' => $validated['message'],
//             'sender_type' => 'farmer',
//         ]);
    
//         return response()->json([
//             'consultation' => $consultation,
//             'message' => $message,
//         ], 201);
//     }
    
//     // Afficher les consultations d'un agriculteur
//     public function getFarmerConsultations($farmerId)
//     {
//         $consultations = Consultation::where('farmer_id', $farmerId)->get();
//         return response()->json($consultations);
//     }

//     // Afficher les consultations d'un expert
//     public function getExpertConsultations($expertId)
//     {
//         $consultations = Consultation::where('expert_id', $expertId)->get();
//         return response()->json($consultations);
//     }
// }


// app/Http/Controllers/ConsultationController.php
namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Expert;
use App\Models\Farmer;
use App\Models\User;
use App\Models\ConsultationMessages;
use Illuminate\Http\Request;


class ConsultationController extends Controller
{
    // Créer une consultation
    public function create(Request $request)
    {
        $validated = $request->validate([
            'expert_id' => 'required|exists:experts,id',
            'message' => 'required|string',
            'farmer_id' => 'required|exists:farmers,id',
        ]);
    
        // Créer une consultation
        $consultation = Consultation::create([
            'expert_id' => $validated['expert_id'],
            'farmer_id' => $validated['farmer_id'],
            'message' => $validated['message'],
            'status' => 'pending', // Initialement en attente
        ]);
    
        // Créer un message associé à cette consultation
        $message = ConsultationMessages::create([
            // 'consultation_id' => $consultation->id,
            // 'sender_id' => $validated['farmer_id'], 
            // 'received_id' => $validated['expert_id'], // L'agriculteur envoie le premier message
            // 'message' => $validated['message'],
            // 'sender_type' => 'farmer',
            'consultation_id' => $consultation->id,
            'sender_id' => $validated['farmer_id'],
            'receiver_id' => $validated['ex
            
            
            
            pert_id'],
            'message' => $request->message,
            'sender_type' => 'farmer',
        ]);
    
        return response()->json([
            'consultation' => $consultation,
            'message' => $message,
        ], 201);
    }
    

    // Afficher les consultations d'un agriculteur
    public function getFarmerConsultations($farmerId)
    {
        $consultations = Consultation::where('farmer_id', $farmerId)->get();
        return response()->json($consultations);
    }

    // Afficher les consultations d'un expert
    public function getExpertConsultations($expertId)
    {
        $consultations = Consultation::where('expert_id', $expertId)->get();
        return response()->json($consultations);
    }
}
