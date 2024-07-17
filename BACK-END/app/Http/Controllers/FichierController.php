<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FichierController extends Controller
{

    public function store(Request $request)
    {
        // Valider les données reçues
        $valider = $request->validate([
            'filiere' => 'required|string',
            'niveau' => 'required|string',
            'chemin' => 'required|string|max:10240', // Exemple : fichier PDF, DOC, DOCX jusqu'à 10MB
        ]);

        // Enregistrer le fichier
        // $file = $request->file('file');
        // $fileName = time() . '_' . $file->getClientOriginalName();
        // $filePath = $file->storeAs('uploads', $fileName); // Stockage du fichier dans le dossier 'storage/app/uploads'

        // Créer une nouvelle entrée dans la base de données
        $fichier = new Fichier();
        $fichier->filiere = $valider['filiere'];
        $fichier->filiere = $valider['niveau'];
        $fichier->filiere = $valider['chemin'];

        // $fichier->niveau = $request->niveau;
        // $fichier->chemin = $request->chemin; // Chemin du fichier stocké
        $fichier->save();

        return response()->json(['message' => 'Fichier enregistré avec succès'], 201);
    }
    //
}
