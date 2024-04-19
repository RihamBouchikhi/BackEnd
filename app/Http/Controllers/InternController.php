<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\User;
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
    
    public function createInternByAdmin(Request $request)
    {

        $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'username' => 'required|string|unique:users,username', 
                // ...........
        ]);
    
        
        $user = User::create([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'Intern', 
                'username' => $validatedData['username'], 
                // ..............
        ]);
    

        $intern = Intern::create([
            'user_id' => $user->id,
            // ................
        ]);
    
        return response()->json(['message' => 'Compte de Intern créé avec succès', 'Intern' => $intern], 201);
    }
    
}