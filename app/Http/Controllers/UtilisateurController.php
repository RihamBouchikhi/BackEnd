<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utilisateur = Utilisateur::all();
        return response()->json($utilisateur);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:utilisateur',
            'password' => 'required',
            'telephone' => 'required',
            'dateNaissance' => 'required|date',
            'genre' => 'required',
            'CIN' => 'required|unique:utilisateur',
            'image' => 'nullable',
        ]);

        $utilisateur = new Utilisateur;
        $utilisateur->nom = $request->input('nom');
        $utilisateur->prenom = $request->input('prenom');
        $utilisateur->email = $request->input('email');
        $utilisateur->password = Hash::make($request->input('password'));
        $utilisateur->telephone = $request->input('telephone');
        $utilisateur->dateNaissance = $request->input('dateNaissance');
        $utilisateur->genre = $request->input('genre');
        $utilisateur->CIN = $request->input('CIN');

        if ($request->file('image')) {
            $imagePath = $request->file('image')->path();
            $imageFile = file_get_contents($imagePath);
            $utilisateur->image = base64_encode($imageFile);
        }

        $utilisateur->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $utilisateur = Utilisateur::find($id);
        return response()->json($utilisateur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:utilisateur,'.$id,
            'password' => 'required',
            'telephone' => 'required',
            'dateNaissance' => 'required|date',
            'genre' => 'required',
            'CIN' => 'required|unique:utilisateur,'.$id,
            'image' => 'nullable',
        ]);

        $utilisateur = Utilisateur::find($id);
        $utilisateur->nom = $request->input('nom');
        $utilisateur->prenom = $request->input('prenom');
        $utilisateur->email = $request->input('email');
        $utilisateur->password = Hash::make($request->input('password'));
        $utilisateur->telephone = $request->input('telephone');
        $utilisateur->dateNaissance = $request->input('dateNaissance');
        $utilisateur->genre = $request->input('genre');
        $utilisateur->CIN = $request->input('CIN');

        if ($request->file('image')) {
            $imagePath = $request->file('image')->path();
            $imageFile = file_get_contents($imagePath);
            $utilisateur->image = base64_encode($imageFile);
        }

        $utilisateur->save();
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $utilisateur = Utilisateur::find($id);
        $utilisateur->delete();
        return response()->json('');
    }
}
