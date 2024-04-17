<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipe;
use App\Models\Projet;
use App\Models\Encadrant;
use App\Models\Stagiaire;
use App\Models\Formulaire;
use App\Http\Controllers\Controller;

class EquipeController extends Controller
{
    /**
     * Stocker une équipe nouvellement créée dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'nom_equipe' => 'required|string|max:255',
            'projet_id' => 'required|exists:projet,id',
        ]);

        $equipe = Equipe::create([
            'nom_equipe' => $validatedData['nom_equipe'],
            'Projet_id' => $validatedData['projet_id'],
            'encadrant_id' => auth()->id(), 
        ]);

        
        return response()->json(['equipe' => $equipe], 201);
    }

    public function show($id)
    {
        $equipe = Equipe::findOrFail($id);
        return response()->json(['equipe' => $equipe], 200);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom_equipe' => 'required|string|max:255',
            'projet_id' => 'required|exists:projet,id',
        ]);

        $equipe = Equipe::findOrFail($id);
        $equipe->update([
            'nom_equipe' => $validatedData['nom_equipe'],
            'Projet_id' => $validatedData['projet_id'],
            'encadrant_id' => auth()->id(), 
        ]);

        return response()->json(['message' => 'Équipe mise à jour avec succès.'], 200);
    }


    public function destroy($id)
    {
        $equipe = Equipe::findOrFail($id);
        $equipe->delete();

        return response()->json(['message' => 'Équipe supprimée avec succès.'], 200);
    }


    public function getStagiairesByDate(Request $request)
    {
        $validatedData = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);

        //  les IDs des formulaires ayant les mêmes dates de début et de fin de stage
        $formulaire_ids = Formulaire::where('date_debut', $validatedData['date_debut'])
                                ->where('date_fin', $validatedData['date_fin'])
                                ->pluck('id');

        //  les stagiaires correspondants aux IDs des formulaires
        $stagiaires = Stagiaire::whereIn('Form_id', $formulaire_ids)->get();

        return response()->json(['stagiaires' => $stagiaires], 200);
    }

    /**
     * Assigner les stagiaires sélectionnés à une équipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $equipe_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignStagiaires(Request $request, $equipe_id)
    {
        $validatedData = $request->validate([
            'stagiaires' => 'required|array',
            'stagiaires.*' => 'exists:stagiaire,id', 
        ]);

        // Récupérer l'équipe à laquelle les stagiaires seront assignés
        $equipe = Equipe::findOrFail($equipe_id);

        // Attribuer les stagiaires à l'équipe
        $equipe->stagiaire()->sync($validatedData['stagiaires']);

        // Retourner une réponse JSON avec un message de succès
        return response()->json(['message' => 'Stagiaires assignés avec succès à l\'équipe.'], 200);
    }


    public function addStagiaire(Request $request, $equipe_id)
    {
        $validatedData = $request->validate([
            'stagiaires' => 'required|array',
            'stagiaires.*' => 'exists:stagiaire,id',
        ]);

        // Récupérer l'équipe à laquelle les stagiaires seront assignés
        $equipe = Equipe::findOrFail($equipe_id);

        // Attribuer les stagiaires sélectionnés à l'équipe
        $equipe->stagiaire()->attach($validatedData['stagiaires']);

        return response()->json(['message' => 'Stagiaires ajoutés à l\'équipe avec succès.'], 201);
    }
}
