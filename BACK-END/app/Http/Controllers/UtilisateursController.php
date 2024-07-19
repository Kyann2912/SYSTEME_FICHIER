<?php

namespace App\Http\Controllers;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UtilisateursController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validation des données de la requête
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:utilisateurs,email|max:255',
                'adresse' => 'required|string|max:255',
                'contact' => 'required|unique:utilisateurs,contact|max:20',
                'mot_passe' => 'required|string|min:8'
            ]);

            // Création d'une instance d'utilisateur
            $utilisateurs = new Utilisateurs();
            $utilisateurs->nom = $validated['nom'];
            $utilisateurs->prenom = $validated['prenom'];
            $utilisateurs->email = $validated['email'];
            $utilisateurs->adresse = $validated['adresse'];
            $utilisateurs->contact = $validated['contact'];
            $utilisateurs->mot_passe = Hash::make($validated['mot_passe']);

            // Vérification de l'existence de l'email ou du contact
            if (Utilisateurs::where('email', $validated['email'])->exists()) {
                throw new \Exception('L\'email spécifié existe déjà.');
            }

            if (Utilisateurs::where('contact', $validated['contact'])->exists()) {
                throw new \Exception('Le contact existe déjà.');
            }

            // Sauvegarde de l'utilisateur
            $utilisateurs->save();

            // Réponse JSON en cas de succès
            return response()->json([
                'status' => 'success',
                'message' => 'Enregistrement réussi',
                'utilisateur' => $utilisateurs
            ], 201); // Code HTTP 201: Created
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de l\'enregistrement',
                'error' => $e->getMessage()
            ], 400); // Code HTTP 400: Bad Request
        }
    }

    /**
     * Log out the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deconnexion(Request $request)
    {
        try {
            // Récupérer l'utilisateur authentifié
            $utilisateurs = Auth::user();

            if ($utilisateurs) {
                // Révoquer le jeton d'authentification de l'utilisateur
                $utilisateurs->tokens()->where('id', $utilisateurs->currentAccessToken()->id)->delete();
            }

            // Déconnexion réussie, retourner une réponse JSON
            return response()->json(['message' => 'Déconnexion réussie']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un message d'erreur
            return response()->json(['message' => 'Échec de la déconnexion', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function connexion(Request $request)
    {
        // Validation des données de la requête
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'mot_passe' => 'required|string|min:8'
        ]);

        try {
            // Tentative d'authentification de l'utilisateur
            if (Auth::attempt($credentials)) {
                $utilisateurs = Auth::utilisateurs();
                $token = $utilisateurs->createToken('AuthToken')->plainTextToken;

                // Réponse JSON en cas de succès
                return response()->json([
                    'status' => 'success',
                    'message' => 'Connexion réussie',
                    'user' => $utilisateurs,
                    'token' => $token
                ]);
            } else {
                // Réponse JSON si les informations d'identification sont incorrectes
                return response()->json([
                    'status' => 'error',
                    'message' => 'Informations d\'identification invalides'
                ], 401); // Code HTTP 401: Unauthorized
            }
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Connexion échouée',
                'error' => $e->getMessage()
            ], 400); // Code HTTP 400: Bad Request
        }
    }
}
