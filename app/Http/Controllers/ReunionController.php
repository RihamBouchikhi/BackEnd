<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use Illuminate\Http\Request;

class ReunionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reunion = Reunion::all();
        return response()->json($reunion);
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
        $reunion = new Reunion([
            'date' => $request->input('date'),
            'duree' => $request->input('duree'),
            'objet' => $request->input('objet'),
            'lieu' => $request->input('lieu'),
            'heure' => $request->input('heure'),
            'encadrant_id' => $request->input('encadrant_id'),
        ]);
        $reunion->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reunion = Reunion::find($id) ;
        return response()->json($reunion) ;
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
        $reunion = Reunion::find($id);
        $reunion->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reunion = Reunion::find($id);
        $reunion->delete();
        return response()->json('');
    }
}
