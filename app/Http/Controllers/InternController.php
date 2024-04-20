<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;
use Carbon\Carbon;

class InternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intern = Intern::all();
        return response()->json($intern);
    }

        // Méthode pour créer un compte de Intern par l'administrateur


    public function showIntern($id)
    {
        
        $intern = Intern::with('profile')->find($id);

        if (!$intern) {
            return response()->json(['message' => 'stagiaire non trouvé'], 404);
        }

        return response()->json(['Intern' => $intern], 200);
    }


}