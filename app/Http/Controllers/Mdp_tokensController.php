<?php

namespace App\Http\Controllers;

use App\Models\Mdp_tokens;
use Illuminate\Http\Request;

class Mdp_tokensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mdp_token = Mdp_tokens::all();
        return response()->json($mdp_token);
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
        $mdp_token = new Mdp_tokens([
        'token' => $request->input('token'),
    ]);
        $mdp_token->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mdp_token = Mdp_tokens::find($id) ;
        return response()->json($mdp_token);
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
        $mdp_token = Mdp_tokens::find($id);
        $mdp_token->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mdp_token = Mdp_tokens::find($id);
        $mdp_token->delete();
        return response()->json('');
    }
}
