<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function createSupervisorByAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'fullName' => 'required|string',
            'email' => 'required|email|unique:profiles,email',
            'password' => 'required|string|min:6',
        ]);
    
        $profile = Profile::create([
            'fullName' => $validatedData['fullName'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'Supervisor', 
        ]);

        $supervisor = Supervisor::create([
            'profile_id' => $profile->id,
            ]);
        return response()->json(['message' => 'Compte d\'Supervisor créé avec succès', 'Supervisor' => $supervisor], 201);
    }


    public function updateSupervisor(Request $request, $id)
    {
        
        $request->validate([
            'fullName' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            //'avatar' => 'nullable|image|max:2048', 
            
        ]);

    
        
        $supervisor = Supervisor::findOrFail($id);
        if (!$supervisor) {
        return response()->json(['message' => 'Supervisor non trouvé'], 404);
        }


        $profile = $supervisor->profile;
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

        return response()->json(['message' => 'Informations stagiaire mises à jour avec succès', 'Supervisor' => $profile]);
    }


    public function showSupervisor($id)
    {
        
        $supervisor = Supervisor::with('profile')->find($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor non trouvé'], 404);
        }

        return response()->json(['Supervisor' => $Supervisor], 200);
    }


    public function deleteSupervisor($id)
    {
        $supervisor = Supervisor::findOrFail($id);

        if (!$supervisor) {
            return response()->json(['message' => 'Supervisor non trouvé'], 404);
        }

        
        $supervisor->profile->delete();

        
        $supervisor->delete();

        return response()->json(['message' => 'Supervisor supprimé avec succès'], 200);
    }
}
