<?php

namespace App\Http\Controllers;
use App\Models\Fichier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class FichierController extends Controller
{

    public function store(Request $request)
    {
        try {
            $valider = $request->validate([
                'filiere' => 'required|string|max:255',
                'niveau' => 'required|string|max:255',
                'chemin' => 'required|string|max:10240',
            ]);
    
            $fichier = new Fichier();
            $fichier->filiere = $valider['filiere'];
            $fichier->niveau = $valider['niveau'];
            $fichier->chemin = $valider['chemin'];
            $fichier->save();
    
            return response()->json(['message' => 'Fichier enregistré avec succès'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'enregistrement du fichier', 'error' => $e->getMessage()], 500);
        }
    }

    public function index()  // Ma fonction permettant d'affiher la liste des fichiers
    {
        try {
            $fichiers = Fichier::all();
    
            return response()->json(['fichiers' => $fichiers], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des fichiers', 'error' => $e->getMessage()], 500);
        }
    }

    public function download($id)
    {
        try {
            $fichier = Fichier::findOrFail($id);
    
            // Récupérer le chemin du fichier
            $chemin = $fichier->chemin;
    
            // Télécharger le fichier
            return Storage::download($chemin);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors du téléchargement du fichier', 'error' => $e->getMessage()], 500);
        }
    }

    
    
    //
}
