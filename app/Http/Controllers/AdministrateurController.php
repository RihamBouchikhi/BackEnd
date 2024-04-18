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
        $email = 'dsiadmin123@gmail.com';
        $password = 'admin56267';

        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'admin',
        ]);

        // Création du compte administrateur associé
        $admin = Administrateur::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Compte administrateur créé avec succès', 'admin' => $admin], 201);
    }


    public function updateAdmin(Request $request, $id)
    {
        // Valider les données de la requête
        $request->validate([
            'fullName' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'niveau_id' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048', 

            
        ]);

    
        // Récupérer l'administrateur à mettre à jour
        $admin = Administrateur::findOrFail($id);
        if (!$admin) {
        return response()->json(['message' => 'Administrateur non trouvé'], 404);
    }
        $user = $admin->user;
        if (!$user) {
            return response()->json(['message' => 'Utilisateur associé non trouvé'], 404);
        }
        // Mettre à jour les informations de l'utilisateur
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

        return response()->json(['message' => 'Informations administrateur mises à jour avec succès', 'admin' => $user]);
    }

    public function showAdmin($id)
    {
        
        $admin = Administrateur::with('user')->find($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrateur non trouvé'], 404);
        }

        return response()->json(['admin' => $admin], 200);
    }

    
    public function deleteAdmin($id)
    {
        // Rechercher l'administrateur par ID
        $admin = Administrateur::findOrFail($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrateur non trouvé'], 404);
        }

        // Supprimer l'utilisateur associé
        $admin->user->delete();

        // Supprimer l'administrateur
        $admin->delete();

        return response()->json(['message' => 'Administrateur supprimé avec succès'], 200);
    }


}
