<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Méthode pour l'inscription d'un utilisateur
    public function register(Request $request)
    {
        
        try {
            // Validation des données avec des règles renforcées
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|min:10|max:15|regex:/^[0-9]+$/', // Validation du téléphone avec un format numérique
            'ifu' => 'required|string|unique:users,ifu|max:20', // Vérifier le format de l'IFU
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:admin,expert,farmer', // Type d'utilisateur

            // Spécificités de farmer
            'farm_count' => 'nullable|integer|min:1', // Doit être un entier positif
            'total_area' => 'nullable|numeric|min:0.1', // Surface doit être un nombre positif
            'location' => 'nullable|string|max:255',

            // Spécificités d'expert
            'speciality' => 'required_if:user_type,expert|string|max:255',
            'experience' => 'required_if:user_type,expert|integer|min:0', // Années d'expérience, minimum 0
            'availability' => 'required_if:user_type,expert|string|max:255',
            'diploma_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Fichier de diplôme (maximum 10MB) Limite pour la bio de l'expert
        ]);

        // Créer l'utilisateur dans la table users
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'ifu' => $validated['ifu'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
        ]);

        // Enregistrer un Farmer si l'utilisateur est de type 'farmer'
        if ($user->user_type === 'farmer') {
            $farmer_data = $request->only(['farm_count', 'total_area', 'location']);
            if (!empty($farmer_data['farm_count']) || !empty($farmer_data['total_area'])) {
                Farmer::create([
                    'user_id' => $user->id,
                    'farm_count' => $validated['farm_count'],
                    'total_area' => $validated['total_area'],
                    'location' => $validated['location'],
                ]);
            }
        } elseif ($user->user_type === 'expert') {
            $expert_data = $request->only(['speciality', 'experience', 'availability', 'diploma_path']);
            $diploma_path = $request->file('diploma_path') ? $request->file('diploma_path')->store('diplomas') : null;

            Expert::create([
                'user_id' => $user->id,
                'speciality' => $validated['speciality'],
                'experience' => $validated['experience'],
                'availability' => $validated['availability'],
                'diploma_path' => $diploma_path,
            ]);
        }


        // Créer un token pour l'utilisateur
        $token = $user->createToken('AgricultureApp')->plainTextToken;

        // Retourner la réponse avec les informations de l'utilisateur et le token
        return response()->json([
            'message' => 'Utilisateur enregistré avec succès',
            'token' => $token,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la création de l\'utilisateur',
            'error' => $e->getMessage(),
        ], 500);
    }
    }

    // Méthode pour la connexion d'un utilisateur
    public function login(Request $request)
    {
        // Validation des données de connexion
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Vérifier les identifiants de l'utilisateur
        $user = User::where('email', $validated['email'])->first();

        // dd($user);
        // dd(Hash::check($validated['password'], $user->password));
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'user' => $user,
                'message' => 'Identifiants incorrects',
            ], 401);
        }
        // Créer un token
        $token = $user->createToken('AgricultureApp')->plainTextToken;
        // dd($user->createToken('AgricultureApp')->plainTextToken);

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

        /**
     * Déconnexion de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // $request->user()->tokens->each(function ($token) {
        //     $token->delete();
        // });
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }
}

