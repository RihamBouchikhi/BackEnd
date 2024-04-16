<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projets = Projet::all();
        return response()->json($projets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sujet' => 'required|string',
            'status' => 'required|string',
            'description' => 'required|string',
            'encadrant_id' => 'required|exists:encadrant,id',
        ]);

        $projet = Projet::create($request->all());
        return response()->json($projet, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $projet = Projet::findOrFail($id);
        return response()->json($projet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sujet' => 'required|string',
            'status' => 'required|string',
            'description' => 'required|string',
        ]);

        $projet = Projet::findOrFail($id);
        $projet->update($request->all());
        return response()->json($projet, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);
        $projet->delete();
        return response()->json('', 204);
    }
}
