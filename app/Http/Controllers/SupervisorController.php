<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{



    public function showSupervisor($id)
    {
        
        $supervisor = Supervisor::with('profile')->find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor non trouvé'], 404);
        }

        return response()->json(['Supervisor' => $supervisor], 200);
    }


}
