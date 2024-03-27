<?php

namespace App\Http\Controllers;

use App\Models\UtilisationTechnologie;
use Illuminate\Http\Request;

class UtilisationTechnologieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utilisationTechnologie = UtilisationTechnologie::all();
        return response()->json($utilisationTechnologie);
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
        $utilisationTechnologie = new UtilisationTechnologie([
            'projet_id' => $request->input('projet_id'),
            'technologie_id' => $request->input('technologie_id'),
        ]);
        $utilisationTechnologie->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $utilisationTechnologie = UtilisationTechnologie::find($id) ;
        return response()->json($utilisationTechnologie);
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
        $utilisationTechnologie = UtilisationTechnologie::find($id);
        $utilisationTechnologie->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $utilisationTechnologie = UtilisationTechnologie::find($id);
        $utilisationTechnologie->delete();
        return response()->json('');
    }
}
