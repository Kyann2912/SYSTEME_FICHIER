<?php

namespace App\Http\Controllers;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valider = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom'=> 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email|max:255',
            'adresse'=> 'required|string|max:255',
            'contact'=>'required|unique:utilisateurs,contact|max:20',
            'mot_passe' => 'required|string|min:8'
        ]);

        try{
            $utilisateurs = new Utilisateurs();
            $utilisateurs->nom =$valider['nom'];
            $utilisateurs->prenom = $valider['prenom'];
            $utilisateurs->email = $valider['email'];
            $utilisateurs->adresse = $valider['adresse'];
            $utilisateurs->contact = $valider['contact'];
            $utilisateurs->mot_passe = Hash::make($valider['mot_passe']);

///verifions si l'email et le contact  existe
            $variable = Utilisateurs::where('email', $valider['email'])->exists();
            $yann =  Utilisateurs::where('contact', $valider['contact'])->exists();
            if ($variable){
                echo "Erreur";

                // return response()->json(["reponse" => "erreur", "message" => "Le contact existe déja."]);

            } elseif($yann){
                echo "Erreur";
                // return response()->json(["reponse" => "erreur", "message" => "L'email spécifié existe déjà."]);
            }
            $utilisateurs->save();
            return response()->json(["reponse"=>"succes","Enregistrement"=>$utilisateurs]);
        }catch(\Exception $e){

            return response()->json(["reponse" => "Inscription echouer", "Cause" => $e->getMessage()]);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
