<?php

namespace App\Http\Controllers;
use App\Models\Fichier;

use Illuminate\Http\Request;

class FichierController extends Controller
{

    public function store(Request $request)
    {
        // Valider les données reçues
        $valider = $request->validate([
            'filiere' => 'required|string',
            'niveau' => 'required|string',
            'chemin' => 'required|string|max:10240',
        ]);

        // Créer une nouvelle entrée dans la base de données
        $fichier = new Fichier();
        $fichier->filiere = $valider['filiere'];
        $fichier->niveau = $valider['niveau'];
        $fichier->chemin = $valider['chemin'];

        $fichier->save();

        return response()->json(['message' => 'Fichier enregistré avec succès'], 201);
    }
    //
}
