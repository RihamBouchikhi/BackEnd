<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Absence;
use App\Models\Avancement;
use App\Models\Projet;
use Carbon\Carbon;

class StagiaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stagiaire = Stagiaire::all();
        return response()->json($stagiaire);
    }

        // Méthode pour créer un compte de stagiaire par l'administrateur
    
    public function createStagiaireByAdmin(Request $request)
    {

        $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
                'motdepasse' => 'required|string|min:6',
                'username' => 'required|string|unique:users,username', 
                // ...........
        ]);
    
        
        $user = User::create([
                'email' => $validatedData['email'],
                'motdepasse' => bcrypt($validatedData['motdepasse']),
                'role' => 'stagiaire', 
                'username' => $validatedData['username'], r
                // ..............
        ]);
    

        $stagiaire = Stagiaire::create([
            'user_id' => $user->id,
            // ................
        ]);
    
        return response()->json(['message' => 'Compte de stagiaire créé avec succès', 'stagiaire' => $stagiaire], 201);
    }
    
}