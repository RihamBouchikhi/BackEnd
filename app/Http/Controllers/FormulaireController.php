<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulaire;

class FormulaireController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            
            'niveau-etude' => 'required|string',
            'etablissement' => 'required|string',
            'CV' => 'required|file',
            'demande-stage' => 'required|file',
            'date-debut' => 'required|date',
            'date-fin' => 'required|date',
            'Offrestage_id' => 'required|exists:offre_stages,id',
        ]);

        // Stockage des données dans la base de données
        $formulaire = Formulaire::create($validatedData);

        // Retourner une réponse
        return response()->json(['message' => 'Formulaire créé avec succès', 'formulaire' => $formulaire], 201);
    }
}
