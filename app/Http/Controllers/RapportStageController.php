<?php

namespace App\Http\Controllers;

use App\Models\RapportStage;
use Illuminate\Http\Request;

class RapportStageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rapportStage = RapportStage::all();
        return response()->json($rapportStage);
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
        $rapportStage = new RapportStage();
        $rapportStage->stage_id = $request->input('stage_id');
        $rapportStage->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rapportStage = RapportStage::find($id);
        return response()->json($rapportStage);
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
        $rapportStage = RapportStage::find($id);
        $rapportStage->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rapportStage = RapportStage::find($id);
        $rapportStage->delete();
        return response()->json('');
    }
}
