<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Encadrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EncadrantController extends Controller
{
    public function createEncadrantByAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'motdepasse' => 'required|string|min:6',
            'fullName' => 'required|string',
            'specialite' => 'required|string',
        ]);
    
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['motdepasse']),
            'role' => 'encadrant', 
            'fullName' => $validatedData['fullName'],
        ]);

        $encadrant = Encadrant::create([
            'user_id' => $user->id,
            'specialite' => $validatedData['specialite'],
            ]);
        return response()->json(['message' => 'Compte d\'encadrant créé avec succès', 'encadrant' => $encadrant], 201);
    }
}
