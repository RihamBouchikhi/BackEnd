<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrateur;
use App\Models\User;

class AdministrateurController extends Controller
{
    // Méthode pour créer un compte administrateur
    public function createAdmin()
    {
        $email = 'dsiadmin@gmail.com';
        $motdepasse = 'administrateur2024';
        $username = 'admin2024'; 

        $user = User::create([
            'email' => $email,
            'motdepasse' => bcrypt($motdepasse),
            'role' => 'admin',
            'username' => $username, 
        ]);

        // Création du compte administrateur associé
        $admin = Administrateur::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Compte administrateur créé avec succès', 'admin' => $admin], 201);
    }


    public function updateAdmin(Request $request)
    {
        $user = auth()->user(); 

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048', 
        ]);

        
        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars'); 
            $user->avatar = $avatarPath;
            $user->save();
        }

        return response()->json(['message' => 'Informations administrateur mises à jour avec succès', 'admin' => $user]);
    }
}
