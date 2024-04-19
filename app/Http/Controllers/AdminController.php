<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Profile;

class AdminController extends Controller
{
    // Méthode pour créer un compte Admin
    public function createAdmin()
    {   
        $fullName = 'Mohammed Karim';
        $email = 'dsiadmin123@gmail.com';
        $password = 'admin56267';

        $profile = Profile::create([
            'fullName' => $fullName,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'admin',
        ]);

        // Création du compte Admin associé
        $admin = Admin::create([
            'profile_id' => $profile->id,
        ]);

        return response()->json(['message' => 'Compte Admin créé avec succès', 'admin' => $admin], 201);
    }


    public function updateAdmin(Request $request, $id)
    {
        
        $request->validate([
            'fullName' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            
        ]);

        
        $admin = Admin::findOrFail($id);
        if (!$admin) {
        return response()->json(['message' => 'Admin non trouvé'], 404);
    }
        $profile = $admin->profile;
        if (!$profile) {
            return response()->json(['message' => 'Utilisateur associé non trouvé'], 404);
        }
        
        $profile->update([
            'fullName' => $request->fullName,
            'phone' => $request->phone,

        ]);
        /*
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars'); 
            $user->avatar = $avatarPath;
            $user->save();
        }*/


        return response()->json(['message' => 'Informations Admin mises à jour avec succès', 'admin' => $profile]);
    }

    public function showAdmin($id)
    {
        
        $admin = Admin::with('profile')->find($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrateur non trouvé'], 404);
        }

        return response()->json(['admin' => $admin], 200);
    }

    
    public function deleteAdmin($id)
    {
        // Rechercher l'administrateur par ID
        $admin = Admin::findOrFail($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrateur non trouvé'], 404);
        }

        // Supprimer l'utilisateur associé
        $admin->profile->delete();

        // Supprimer l'administrateur
        $admin->delete();

        return response()->json(['message' => 'Administrateur supprimé avec succès'], 200);
    }


}
