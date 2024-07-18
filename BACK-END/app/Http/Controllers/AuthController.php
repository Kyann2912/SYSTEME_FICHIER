<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateurs; // Assurez-vous d'importer le modèle Utilisateurs si ce n'est pas déjà fait

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Valider les données reçues
        $credentials = $request->validate([
            'email' => 'required|email|unique:utilisateurs,email|max:255',
            'mot_passe' => 'required|string|min:8'
        ]);

        // Tenter de s'authentifier avec les identifiants fournis
        if (Auth::attempt($credentials)) {
            // Authentification réussie

            $utilisateurs = Auth::user(); // Récupérer l'utilisateur authentifié

            return response()->json([
                'message' => 'Connexion réussie',
                'utilisateur' => $utilisateurs,
                'token' => $utilisateurs->createToken('AuthToken')->plainTextToken,
            ]);
        } else {
            // Authentification échouée
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }
    }
}
