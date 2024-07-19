<?php

namespace App\Http\Controllers;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UtilisateursController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:utilisateurs,email|max:255',
                'adresse' => 'required|string|max:255',
                'contact' => 'required|unique:utilisateurs,contact|max:20',
                'mot_passe' => 'required|string|min:8'
            ]);

            $utilisateurs = new Utilisateurs();
            $utilisateurs->nom = $validated['nom'];
            $utilisateurs->prenom = $validated['prenom'];
            $utilisateurs->email = $validated['email'];
            $utilisateurs->adresse = $validated['adresse'];
            $utilisateurs->contact = $validated['contact'];
            $utilisateurs->mot_passe = Hash::make($validated['mot_passe']);

            if (Utilisateurs::where('email', $validated['email'])->exists()) {
                throw new \Exception('L\'email spécifié existe déjà.');
            }

            if (Utilisateurs::where('contact', $validated['contact'])->exists()) {
                throw new \Exception('Le contact existe déjà.');
            }

            $utilisateurs->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Enregistrement réussi',
                'utilisateur' => $utilisateurs
            ], 201); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de l\'enregistrement',
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function deconnexion(Request $request)
    {
        try {
            $utilisateurs = Auth::user();

            if ($utilisateurs) {
                $utilisateurs->tokens()->where('id', $utilisateurs->currentAccessToken()->id)->delete();
            }

            return response()->json(['message' => 'Déconnexion réussie']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Échec de la déconnexion', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    

     public function login(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'mot_passe' => 'required|string|min:8',
        ]);

        if (Auth::attempt($validated)){
            $utilisateurs = Auth::user();

            $accessToken = $utilisateurs->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Connexion réussie',
                'access_token' => $accessToken,
                'user' => [
                    'id' => $utilisateurs->id,
                    'email' => $utilisateurs->email,
                ]
            ]);
        } else {
            throw new \Exception('Identifiants de connexion invalides.');
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'erreur',
            'message' => 'Échec de la connexion',
            'error' => $e->getMessage()
        ], 401);
    }
}

}
