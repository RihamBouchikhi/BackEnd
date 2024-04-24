<?php

namespace App\Http\Controllers;

use App\Traits\Refactor;
use App\Models\Demand;

class DemandController 
{
    use Refactor;

    public function show($id){
        $demande = Demand::find($id);
        if (!$demande) {
            return response()->json(['message' => 'demande de stage non trouvée'], 404);
        }
        return response()->json($this->refactorDemand( $demande));

    }
}
