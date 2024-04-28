<?php

namespace App\Http\Controllers;

use App\Traits\Delete;
use App\Traits\Get;
use App\Traits\Refactor;
use App\Traits\Store;
use App\Traits\Update;
use Illuminate\Http\Request;
use App\Models\Offer;


class OfferController
{
    use Refactor, Store,Update,Delete,Get;


    public function index(){
        return $this->GetAll('offers');
    }    

    public function show($id){
        return $this->GetByDataId('offers',$id);
    }

    public function store(Request $request)
    {
        // Création de l'offre de stage
        $offre = $this->storeOffer($request);
        return response()->json($this->refactorOffer($offre));
    }
 
    public function update(Request $request, $id)
    {
        $offer= Offer::find($id);
        if (!$offer) {
            return response()->json(['message' => 'cannot update undefined offer!'], 404);
        }
        $updatedOffer=$this->updateOffer($request,$offer);
        return response()->json($this->refactorOffer($updatedOffer));
    }

    public function destroy($id)
    {
        $offer = Offer::find($id);
        if (!$offer) {
            return response()->json(['message' => 'Ocannot delete undefined offer!'], 404);
        }
        $offer->delete();
        return response()->json(['message' => 'Offre de stage supprimée avec succès']);
    }
}
