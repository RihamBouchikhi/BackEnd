<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projet = Projet::all();
        return response()->json($projet);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



// ...

    public function getLastProjetId()
    {
        $lastProjetId = DB::table('projet')->orderBy('created_at', 'desc')->value('id');
        return response()->json(['last_projet_id' => $lastProjetId]);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        $projet = new Projet([
            'sujet' => $request->input('sujet'),
            'status' => $request->input('status'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'image'=> $request->input('image'),
            'equipe_id' => $request->input('equipe_id'),
        ]);
        $projet->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $projet = Projet::find($id) ;
        return response()->json($projet);
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
        $projet = Projet::find($id);
        $projet->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $projet = Projet::find($id);
        $projet->delete();
        return response()->json('');
    }


    public function getProjetsDetails()
    {
        $projets = Projet::with([
            'equipe' => function ($query) {
                $query->select('id', 'nom_equipe');
            },
            'equipe.stagiaires' => function ($query) {
                $query->select('id', 'nom', 'prenom', 'equipe_id');
            },
        ])->select('id', 'sujet', 'status', 'equipe_id')->get();

        return response()->json($projets);
    }









}
