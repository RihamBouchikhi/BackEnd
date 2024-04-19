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
        ]);
    
        return response()->json(['message' => 'Compte de Intern créé avec succès', 'Intern' => $intern], 201);
    }
    


    public function updateStagiaire(Request $request, $id)
    {
        
        $request->validate([
            'fullName' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'niveau_id' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048', 
            
        ]);


        $stagiaire = Stagiaire::findOrFail($id);
        if (!$stagiaire) {
        return response()->json(['message' => 'stagiaire non trouvé'], 404);
        }

        $user = $stagiaire->user;
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


        return response()->json(['message' => 'Informations stagiaire mises à jour avec succès', 'stagiaire' => $user]);
    }


    public function showStagiaire($id)
    {
        
        $stagiaire = Stagiaire::with('user')->find($id);

        if (!$stagiaire) {
            return response()->json(['message' => 'stagiaire non trouvé'], 404);
        }

        return response()->json(['stagiaire' => $stagiaire], 200);
    }


    public function deleteStagiaire($id)
    {
        $stagiaire = Stagiaire::findOrFail($id);

        if (!$stagiaire) {
            return response()->json(['message' => 'Stagiaire non trouvé'], 404);
        }

        
        $stagiaire->user->delete();

        $stagiaire->delete();

        return response()->json(['message' => 'Stagiaire supprimé avec succès'], 200);
    }


    public function soumettreRapportEtProjet(Request $request, $id)
    {
        $request->validate([
            'rapport' => 'required|string',
            'projet_final' => 'required|string',
        ]);

        $stagiaire = Stagiaire::findOrFail($id);
        if (!$stagiaire) {
            return response()->json(['message' => 'Stagiaire non trouvé'], 404);
        }

        $stagiaire->update([
            'RapportStage' => $request->rapport,
            'ProjetFinale' => $request->projet_final,
        ]);

        
        return response()->json(['message' => 'Rapport et projet final soumis avec succès', 'stagiaire' => $stagiaire]);
    }
}