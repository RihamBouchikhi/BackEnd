<?php

namespace App\Http\Controllers;

use App\Models\Attestation;
use Illuminate\Http\Request;

class AttestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attestation = Attestation::all();
        return response()->json($attestation);
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
        $attestation = new Attestation;
        $attestation->date = $request->input('date');
        $attestation->duree_stage = $request->input('duree_stage');
        $attestation->contenu = $request->input('contenu');
        $attestation->administrateur_id = $request->input('administrateur_id');
        $attestation->stagiaire_id = $request->input('stagiaire_id');
        $attestation->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attestation = Attestation::find($id);
        return response()->json($attestation);
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
        $attestation = Attestation::find($id);
        $attestation->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id)
    {
        $attestation = Attestation::find($id);
        $attestation->delete();
        return response()->json('');
    }
}
