<?php

namespace App\Http\Controllers;

use App\Traits\Delete;
use App\Traits\Refactor;
use App\Traits\Store;
use App\Traits\Update;
use Illuminate\Http\Request;
use App\Models\Offer;


class OfferController
{
    use Refactor, Store,Update,Delete;
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sector' => 'required|string|max:100',
            'experience' => 'required|string',
            'skills' => 'required|string', 
            'direction' => 'required|string', 
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

        return response()->json($this->refactorOffer( $offre));
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
            'direction' => 'required|string', 
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
