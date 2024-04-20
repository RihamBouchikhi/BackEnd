<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{


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

        return response()->json(['Supervisor' => $supervisor], 200);
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
