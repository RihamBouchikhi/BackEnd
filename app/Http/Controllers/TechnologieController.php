<?php

namespace App\Http\Controllers;

use App\Models\Technologie;
use Illuminate\Http\Request;

class TechnologieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technologie = Technologie::all();
        return response()->json($technologie);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_technologie' => 'required',
            'image' => 'nullable',
        ]);

        $technologie = new Technologie;
        $technologie->nom_technologie = $request->input('nom_technologie');
        $technologie->image = $request->input('image');

        $technologie->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $technologie = Technologie::find($id);
        return response()->json($technologie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom_technologie' => 'required',
            'image' => 'nullable',
        ]);

        $technologie = Technologie::find($id);
        $technologie->nom_technologie = $request->input('nom_technologie');
        $technologie->image = $request->input('image');

        $technologie->save();
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $technologie = Technologie::find($id);
        $technologie->delete();
        return response()->json('');
    }
}
