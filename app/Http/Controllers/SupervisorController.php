<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Encadrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
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


    public function updateEncadrant(Request $request, $id)
    {
        
        $request->validate([
            'fullName' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'niveau_id' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048', 
            'specialite' => 'required|string',
            
        ]);

    
        
        $encadrant = Encadrant::findOrFail($id);
        if (!$encadrant) {
        return response()->json(['message' => 'Encadrant non trouvé'], 404);
        }

        $encadrant->update([
            'specialite' => $request->specialite,
        ]);

        $user = $encadrant->user;
        if (!$user) {
            return response()->json(['message' => 'Utilisateur associé non trouvé'], 404);
        }
        
        $user->update([
            'fullName' => $request->fullName,
            'phone' => $request->phone,
            'city' => $request->city,
            'niveau_id' => $request->niveau_id,
        ]);

        
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars'); 
            $user->avatar = $avatarPath;
            $user->save();
        }

        return response()->json(['message' => 'Informations encadrant mises à jour avec succès', 'encadrant' => $user]);
    }


    public function showEncadrant($id)
    {
        
        $encadrant = Encadrant::with('user')->find($id);

        if (!$encadrant) {
            return response()->json(['message' => 'Encadrant non trouvé'], 404);
        }

        return response()->json(['encadrant' => $encadrant], 200);
    }


    public function deleteEncadrant($id)
    {
        $encadrant = Encadrant::findOrFail($id);

        if (!$encadrant) {
            return response()->json(['message' => 'Encadrant non trouvé'], 404);
        }

        
        $encadrant->user->delete();

        
        $encadrant->delete();

        return response()->json(['message' => 'Encadrant supprimé avec succès'], 200);
    }
}
