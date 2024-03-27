<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absence = Absence::all();
        return response()->json($absence);
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
        $absence = new Absence([
            'date' => $request->input('date'),
            'justification' => $request->input('justification'),
            'stagiaire_id' => $request->input('stage_id'),
        ]);
        $absence->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $absence = Absence::find($id) ;
        return response()->json($absence);
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
        $absence = Absence::find($id);
        $absence->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absence = Absence::find($id);
        $absence->delete();
        return response()->json('');
    }


    //getting today absence
    public function getAbsencesAujourdhui()
    {
        $dateAujourdhui = Carbon::today();

        $absences = Absence::whereDate('date', $dateAujourdhui)
            ->with('stagiaire:id,nom,prenom,justification')
            ->join('stagiaire', 'absence.stagiaire_id', '=', 'stagiaire.id')
            ->get(['stagiaire.nom', 'stagiaire.prenom', 'absence.justification']);

        return response()->json($absences);
    }


}
