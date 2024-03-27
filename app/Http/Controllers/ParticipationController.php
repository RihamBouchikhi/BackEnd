<?php

namespace App\Http\Controllers;

use App\Models\Participation;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participation = Participation::all();
        return response()->json($participation);
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
        $participation = new Participation();
        $participation->stagiaire_id = $request->input('stagiaire_id');
        $participation->reunion_id = $request->input('reunion_id');
        $participation->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $participation = Participation::find($id);
        return response()->json($participation);
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
        $participation = Participation::find($id);
        $participation->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participation = Participation::find($id);
        $participation->delete();
        return response()->json('');
    }
}
