<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stage = Stage::all();
        return response()->json($stage);
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
        $stage = new Stage([
            'date_debut' => $request->input('date_debut'),
            'duree' => $request->input('duree'),
            'stagiaire_id' => $request->input('stagiaire_id'),
            'administrateur_id' => $request->input('administrateur_id'),
            'encadrant_id' => $request->input('encadrant_id'),
        ]);
        $stage->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stage = Stage::find($id) ;
        return response()->json($stage) ;
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
        $stage = Stage::find($id);
        $stage->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stage = Stage::find($id);
        $stage->delete();
        return response()->json('');
    }
}
