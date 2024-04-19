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
    
        $validatedData = $request->validate([
            
            'niveau_etude' => 'required|string',
            'etablissement' => 'required|string',
            'CV' => 'required|file',
            'demande_stage' => 'required|file',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'Offrestage_id' => 'required|integer',
        ]);


        $formulaire = Formulaire::create([
            'niveau_etude' => $validatedData['niveau_etude'],
            'etablissement' => $validatedData['etablissement'],
            'CV' => $validatedData['CV'],
            'demande_stage' => $validatedData['demande_stage'],
            'date_debut' => $validatedData['date_debut'],
            'date_fin' => $validatedData['date_fin'],
            'Offrestage_id' => $validatedData['Offrestage_id'],
        ]);
        
        return response()->json(['message' => 'Formulaire créé avec succès', 'formulaire' => $formulaire], 201);
    }
}


