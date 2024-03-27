<?php

namespace App\Http\Controllers;

use App\Models\Encadrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class EncadrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $encadrant = Encadrant::all();
        return response()->json($encadrant);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check Email
        $user = Encadrant::where('email', $fields['email'])->first();

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
            'id' => 'required|unique:encadrant', // Ajoutez la validation pour l'ID unique
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:encadrant',
            'password' => 'required',
            'telephone' => 'required',
            'dateNaissance' => 'required|date',
            'genre' => 'required',
            'CIN' => 'required|unique:encadrant',
            'fonction' => 'required',
            'image' => 'nullable',
            'couverture' => 'nullable',
        ]);

        $encadrant = new Encadrant;
        $encadrant->id = $request->input('id'); // Ajoutez l'ID manuellement
        $encadrant->nom = $request->input('nom');
        $encadrant->prenom = $request->input('prenom');
        $encadrant->email = $request->input('email');
        $encadrant->password = \Hash::make($request->input('password'));
        $encadrant->telephone = $request->input('telephone');
        $encadrant->dateNaissance = $request->input('dateNaissance');
        $encadrant->genre = $request->input('genre');
        $encadrant->CIN = $request->input('CIN');
        $encadrant->fonction = $request->input('fonction');
        $encadrant->image = $request->input('image');
        $encadrant->couverture = $request->input('couverture');
        $encadrant->save();
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $encadrant = Encadrant::find($id) ;
        return response()->json($encadrant) ;
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
            'email' => 'required|email',
            'password' => 'required',
            'telephone' => 'required',
            'dateNaissance' => 'required|date',
            'genre' => 'required',
            'CIN' => 'required',
            'fonction' => 'required',
            'image' => 'nullable',
            'couverture' => 'nullable',
        ]);

        $encadrant = Encadrant::find($id);

        $encadrant->nom = $request->input('nom');
        $encadrant->prenom = $request->input('prenom');
        $encadrant->email = $request->input('email');
        $encadrant->password = \Hash::make($request->input('password'));
        $encadrant->telephone = $request->input('telephone');
        $encadrant->dateNaissance = $request->input('dateNaissance');
        $encadrant->genre = $request->input('genre');
        $encadrant->CIN = $request->input('CIN');
        $encadrant->fonction = $request->input('fonction');
        $encadrant->image = $request->input('image');
        $encadrant->couverture = $request->input('couverture');
        $encadrant->save();

        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $encadrant = Encadrant::find($id);
        $encadrant->delete();
        return response()->json('');
    }
}
