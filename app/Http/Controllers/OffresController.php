<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offres;
use App\Models\Projet;

class OffresController extends Controller
{
    public function index()
    {
        $offres = Offres::all();
        return response()->json($offres);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'dure' => 'required|string|max:100',
            'sujet_projet' => 'required|string|exists:projet,sujet', 
            'Admin_id' => 'required|integer',
        ]);

        // Récupérer le projet par son titre
        $projet = Projet::where('sujet', $request->sujet_projet)->firstOrFail();

        
        $offre = Offres::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'dure' => $request->dure,
            'Admin_id' => $request->Admin_id,
            'Projet_id' => $projet->id, 
        ]);

        return response()->json(['message' => 'Offre de stage créée avec succès', 'offre' => $offre], 201);
    }


    public function show($id)
    { 
        $offre = Offres::findOrFail($id);

        if (!$offre) {
            return response()->json(['message' => 'Offre de stage non trouvée'], 404);
        }

        return response()->json($offre);
    }

    
    
    public function update(Request $request, $id)
    {
        $offre = Offres::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'dure' => 'required|string|max:100',
            'Projet_id' => 'required|exists:projet,id',
        ]);

        $offre->update($request->all());

        return response()->json(['message' => 'Offre de stage mise à jour avec succès', 'offre' => $offre]);
    }


    public function destroy($id)
    {
        $offre = Offres::findOrFail($id);
        $offre->delete();

        return response()->json(['message' => 'Offre de stage supprimée avec succès']);
    }
}
