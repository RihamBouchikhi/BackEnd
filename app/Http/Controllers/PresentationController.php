<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentation = Presentation::all();
        return response()->json($presentation);
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
        $presentation = new Presentation([
            'date' => $request->input('date'),
            'heure' => $request->input('heure'),
            'description' => $request->input('description'),
            'stage_id' => $request->input('stage_id'),
        ]);
        $presentation->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $presentation = Presentation::find($id) ;
        return response()->json($presentation) ;
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
        $presentation = Presentation::find($id);
        $presentation->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $presentation = Presentation::find($id);
        $presentation->delete();
        return response()->json('');
    }
}
