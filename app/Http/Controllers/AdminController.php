<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    // Méthode pour créer un compte Admin
    public function createAdmin()
    {
        $email = 'dsiadmin123@gmail.com';
        $password = 'admin56267';
        $username = 'admin2'; 

        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'admin',
            'username' => $username, 
        ]);

        // Création du compte Admin associé
        $admin = Admin::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Compte Admin créé avec succès', 'admin' => $admin], 201);
    }


        public function updateAdmin(Request $request, $id)
    {
        // Valider les données de la requête
        $request->validate([
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048', 
        ]);

    
        // Récupérer l'Admin à mettre à jour
        $admin = Admin::findOrFail($id);
        if (!$admin) {
        return response()->json(['message' => 'Admin non trouvé'], 404);
    }
        $user = $admin->user;

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
        ]);

        // Mettre à jour l'avatar si présent dans la requête
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars'); 
            $user->avatar = $avatarPath;
            $user->save();
        }

        // Répondre avec un message de succès
        return response()->json(['message' => 'Informations Admin mises à jour avec succès', 'admin' => $user]);
    }

}