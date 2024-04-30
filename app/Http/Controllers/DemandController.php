<?php

namespace App\Http\Controllers;

use App\Traits\Refactor;
use App\Models\Demand;
use App\Traits\Store;
use App\Traits\Update;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    use Refactor, Store,Update;
    public function __construct(){
        $this->middleware('role:user')->only('store');
        $this->middleware('role:admin')->only(['accepteDemand','destroy']);
    }
    public function store(Request $request){
        // Création de l'offre de stage
        $demand = $this->storeDemand($request);
        return $demand;
    }
    public function update(Request $request, $id){
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
        if ($demand->status === 'Approved'&&$traitement==='approve') {
            return response()->json(['message' => 'demand alraedy Approved'], 404);
        }
        if($traitement==='approve'){
           return response()->json($this->storeAcceptedIntern($demand) );
        }
        if($traitement==='reject'){
            $demand->status='Rejected';
            $demand->save();
            return response()->json($this->refactorDemand($demand));
        }
    }
    public function destroy($id){
        $demand = demand::find($id);
        if (!$demand) {
            return response()->json(['message' => 'Ocannot delete undefined demand!'], 404);
        }
        $this->deletOldFiles($demand,'demandeStage');
        $demand->delete();
        return response()->json(['message' => 'Offre de stage supprimée avec succès']);
    }
}

