<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;


class OfferController extends Controller
{
    public function index()
    {
        $offres = Offer::all();
        return response()->json($offres);
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sector' => 'required|string|max:100',
            'experience' => 'required|string',
            'skills' => 'required|string', 
            'deriction' => 'required|string', 
            'duration' => 'required|string', 
            'type' => 'required|string', 
            'visibility' => 'required|boolean',
            'status' => 'required|string',
            'city' => 'required|string',
            
        ]);

        // Création de l'offre de stage
        $offre = Offer::create($validatedData);

        return response()->json(['message' => 'Offre de stage créée avec succès', 'offre' => $offre], 201);
    }



    public function show($id)
    {
        $offre = Offer::find($id);

        if (!$offre) {
            return response()->json(['message' => 'Offre de stage non trouvée'], 404);
        }

        return response()->json($offre);
    }


    
    
    public function update(Request $request, $id)
    {
        
        $offre = Offer::find($id);

        if (!$offre) {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sector' => 'required|string|max:100',
            'experience' => 'required|string',
            'skills' => 'required|string',
            'deriction' => 'required|string', 
            'duration' => 'required|string', 
            'type' => 'required|string', 
            'visibility' => 'required|boolean', 
            'status' => 'required|string',
            'city' => 'required|string',
            
        ]);

        
        $offre->update($validatedData);

        return response()->json(['message' => 'Offre de stage mise à jour avec succès', 'offre' => $offre]);
    }



    public function destroy($id)
    {
        $offre = Offer::find($id);

        if (!$offre) {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }

        
        $offre->delete();

        return response()->json(['message' => 'Offre de stage supprimée avec succès']);
    }
}
