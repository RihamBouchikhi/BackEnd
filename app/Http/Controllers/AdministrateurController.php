<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use App\Models\Encadrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdministrateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administrateur = Administrateur::all();
        return response()->json($administrateur);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:administrateur', // Ajoutez la validation pour l'ID unique
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:administrateur',
            'password' => 'required',
            'telephone' => 'required',
            'dateNaissance' => 'required|date',
            'genre' => 'required',
            'CIN' => 'required|unique:administrateur',
            'image' => 'nullable',
        ]);

        $administrateur = new Administrateur;
        $administrateur->id = $request->input('id'); // Ajoutez l'ID manuellement
        $administrateur->nom = $request->input('nom');
        $administrateur->prenom = $request->input('prenom');
        $administrateur->email = $request->input('email');
        $administrateur->password = \Hash::make($request->input('password'));
        $administrateur->telephone = $request->input('telephone');
        $administrateur->dateNaissance = $request->input('dateNaissance');
        $administrateur->genre = $request->input('genre');
        $administrateur->CIN = $request->input('CIN');
        $administrateur->image = $request->input('image');
        $administrateur->save();

        return response()->json('');
    }


    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check Email
        $user = Administrateur::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Incorrect informations'
            ], 401);
        }

        $token = $user->createToken($user->getTable().'Token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $administrateur = Administrateur::find($id);
        return response()->json($administrateur);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:administrateur',
            'password' => 'required',
            'telephone' => 'required',
            'dateNaissance' => 'required|date',
            'genre' => 'required',
            'CIN' => 'required|unique:administrateur',
            'image' => 'nullable',
        ]);

        $administrateur = Administrateur::find($id);
        $administrateur->nom = $request->input('nom');
        $administrateur->prenom = $request->input('prenom');
        $administrateur->email = $request->input('email');
        $administrateur->password = \Hash::make($request->input('password'));
        $administrateur->telephone = $request->input('telephone');
        $administrateur->dateNaissance = $request->input('dateNaissance');
        $administrateur->genre = $request->input('genre');
        $administrateur->CIN = $request->input('CIN');
        $administrateur->image = $request->input('image');


        $administrateur->save();


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $administrateur = Administrateur::find($id);
        $administrateur->delete();
        return response()->json('');
    }
}
