<?php

namespace App\Http\Controllers;

use App\Traits\Refactor;
use App\Models\Demand;
use App\Traits\Store;
use App\Traits\Update;
use Illuminate\Http\Request;

class DemandController 
{
    use Refactor, Store,Update;
    public function store(Request $request)
    {
        // Création de l'offre de stage
        $demand = $this->storeDemand($request);
        return $demand;
    }
 
    public function update(Request $request, $id)
    {
        $demand= Demand::find($id);
        if (!$demand) {
            return response()->json(['message' => 'cannot update undefined demand!'], 404);
        }
        $updatedDemand=$this->updateDemand($request,$demand);
        return response()->json($this->refactorDemand($updatedDemand));
    }
    public function accepteDemand($id ,$traitement){
        $demand=Demand::find($id);
        if (!$demand) {
            return response()->json(['message' => 'cannot '.$traitement.' undefined demand!'], 404);
        }
         if ($demand->status === 'Accepted') {
            return response()->json(['message' => 'demand alraedy accepted'], 404);
        }
        if($traitement==='accepte'){
           return $this->storeAcceptedIntern($demand);
        }
    }
    public function destroy($id)
    {
        $demand = demand::find($id);
        if (!$demand) {
            return response()->json(['message' => 'Ocannot delete undefined demand!'], 404);
        }
        $demand->delete();
        return response()->json(['message' => 'Offre de stage supprimée avec succès']);
    }
}

