<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Profile;
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
                'email' => 'required|email|unique:profiles,email',
                'password' => 'required|string|min:6',
                
        ]);
    
        
        $profile = Profile::create([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => 'Intern', 
                
        ]);
    

        $intern = Intern::create([
            'profile_id' => $profile->id,
        ]);
    
        return response()->json(['message' => 'Compte de Intern créé avec succès', 'Intern' => $intern], 201);
    }
    


    public function updateIntern(Request $request, $id)
    {
        
        $request->validate([
            'fullName' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            
        ]);


        $intern = Intern::findOrFail($id);
        if (!$intern) {
        return response()->json(['message' => 'stagiaire non trouvé'], 404);
        }

        $profile = $intern->profile;
        if (!$profile) {
            return response()->json(['message' => 'Utilisateur associé non trouvé'], 404);
        }
        // Mettre à jour les informations de l'utilisateur
        $profile->update([
            'fullName' => $request->fullName,
            'phone' => $request->phone,

        ]);
        /*
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars'); 
            $profile->avatar = $avatarPath;
            $profile->save();
        }*/


        return response()->json(['message' => 'Informations stagiaire mises à jour avec succès', 'stagiaire' => $profile]);
    }


    public function showIntern($id)
    {
        
        $intern = Intern::with('profile')->find($id);

        if (!$intern) {
            return response()->json(['message' => 'stagiaire non trouvé'], 404);
        }

        return response()->json(['stagiaire' => $intern], 200);
    }


    public function deleteIntern($id)
    {
        $intern = Intern::findOrFail($id);

        if (!$intern) {
            return response()->json(['message' => 'Stagiaire non trouvé'], 404);
        }

        
        $intern->profile->delete();

        $intern->delete();

        return response()->json(['message' => 'Stagiaire supprimé avec succès'], 200);
    }


}