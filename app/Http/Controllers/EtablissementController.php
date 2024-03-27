<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etablissement = Etablissement::all();
        return response()->json($etablissement);
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
        $etablissement = new Etablissement;
        $etablissement->nom_etablissement = $request->input('nom_etablissement');
        $etablissement->adresse = $request->input('adresse');
        $etablissement->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $etablissement = Etablissement::find($id);
        return response()->json($etablissement);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $etablissement = Etablissement::find($id);
        $etablissement->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $etablissement = Etablissement::find($id);
        $etablissement->delete();
        return response()->json('');
    }
}
