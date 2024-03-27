<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\Equipe;
use App\Models\Encadrant;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use Carbon\Carbon;


class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipe = Equipe::all();
        return response()->json($equipe);
    }

    public function getStagiairesByEquipe($equipeId)
    {
        $stagiaires = Stagiaire::where('equipe_id', $equipeId)->get();

        return response()->json($stagiaires);
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
        $equipe = new Equipe();
        $equipe->id = $request->input('id');
        $equipe->nom_equipe = $request->input('nom_equipe');
        $equipe->encadrant_id = $request->input('encadrant_id');
        $equipe->save();

        return response()->json('');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipe = Equipe::find($id);
        return response()->json($equipe);
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
        $equipe = Equipe::find($id);
        $equipe->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipe = Equipe::find($id);
        $equipe->delete();
        return response()->json('');
    }

    /*
     * Equipe Details
     */
    public function getEquipesDetails(Request $request)
    {
        $equipes = Equipe::with(['stagiaires' => function ($query) {
            $query->with('stage', 'equipe.projets');
        }, 'projets.technologies'])->get();

        foreach ($equipes as $equipe) {
            foreach ($equipe->stagiaires as $stagiaire) {
                if ($stagiaire->stage) {
                    // Calculer la date de fin du stage
                    $startDate = Carbon::createFromFormat('Y-m-d', $stagiaire->stage->date_Debut);
                    $endDate = $startDate->copy()->addMonths($stagiaire->stage->duree);
                    $stagiaire->stage->date_Fin = $endDate->toDateString();

                    // Calculer les jours restants
                    $now = Carbon::now();
                    $stagiaire->stage->jours_restants = $endDate->diffInDays($now);
                }

                // Assign each stagiaire's projet from the equipe's projets
                foreach ($equipe->projets as $projet) {
                    $stagiaire->projet = $projet;
                }
            }

            $equipe_images = [];
            foreach ($equipe->stagiaires as $stagiaire) {
                if ($stagiaire->image) {
                    array_push($equipe_images, $stagiaire->image);
                }
            }
            $equipe->equipe_images = $equipe_images;

            $progres_total = 0;
            foreach ($equipe->projets as $projet) {
                $progres_total += $projet->avancements()->sum('valeur');

                $avancements_types_count = $projet->avancements()->distinct('type')->count('type');
                $progres_total += round($projet->avancements()->sum('valeur') / $avancements_types_count, 2);
            }

            // Calculating progress outside the loop
            $equipe->progres_total = $equipe->projets->count() > 0 ? $progres_total / $equipe->projets->count() : 0;
        }

        // Returning response outside the loop
        return response()->json($equipes);
    }

    public function getEquipeDetails(Request $request, $equipeId)
    {
        $equipe = Equipe::with(['stagiaires' => function ($query) {
            $query->with('stage', 'equipe.projets');
        }, 'projets.technologies'])->find($equipeId);

        if(!$equipe) {
            return response()->json(['message' => 'Equipe not found'], 404);
        }

        foreach ($equipe->stagiaires as $stagiaire) {
            if ($stagiaire->stage) {
                // Calculer la date de fin du stage
                $startDate = Carbon::createFromFormat('Y-m-d', $stagiaire->stage->date_Debut);
                $endDate = $startDate->copy()->addMonths($stagiaire->stage->duree);
                $stagiaire->stage->date_Fin = $endDate->toDateString();

                // Calculer les jours restants
                $now = Carbon::now();
                $stagiaire->stage->jours_restants = $endDate->diffInDays($now);
            }

            // Assign each stagiaire's projet from the equipe's projets
            foreach ($equipe->projets as $projet) {
                $stagiaire->projet = $projet;
            }
        }

        $equipe_images = [];
        foreach ($equipe->stagiaires as $stagiaire) {
            if ($stagiaire->image) {
                array_push($equipe_images, $stagiaire->image);
            }
        }
        $equipe->equipe_images = $equipe_images;

        $progres_total = 0;
        foreach ($equipe->projets as $projet) {
            $progres_total += $projet->avancements()->sum('valeur');

            $avancements_types_count = $projet->avancements()->distinct('type')->count('type');
            $progres_total += round($projet->avancements()->sum('valeur') / $avancements_types_count, 2);
        }

        // Calculating progress outside the loop
        $avancements_types = $projet->avancements()->select('type', \DB::raw('ROUND(SUM(valeur), 2) as total, COUNT(valeur) as count'))->groupBy('type')->get();

        $progres_total = 0;
        $progres_partiel_count = $avancements_types->count();

        foreach ($avancements_types as $avancement) {
            $progres_type = round($avancement->total / $avancement->count, 2);
            $progres_total += $progres_type;
            $avancement->progres_type = $progres_type;
        }

        $equipe->progres_total = $progres_partiel_count > 0 ? round($progres_total / $progres_partiel_count, 2) : 0;
        $equipe->avancements_types = $avancements_types;



        // Returning response
        return response()->json($equipe);
    }






    public function getEncadrantEquipesDetails(Request $request, $encadrantId)
    {
        $equipes = Equipe::with(['stagiaires' => function ($query) {
            $query->with('stage', 'equipe.projets');
        }, 'projets.technologies'])
            ->where('encadrant_id', $encadrantId)
            ->get();

        foreach ($equipes as $equipe) {
            foreach ($equipe->stagiaires as $stagiaire) {
                if ($stagiaire->stage) {
                    // Calculer la date de fin du stage
                    $startDate = Carbon::createFromFormat('Y-m-d', $stagiaire->stage->date_Debut);
                    $endDate = $startDate->copy()->addMonths($stagiaire->stage->duree);
                    $stagiaire->stage->date_Fin = $endDate->toDateString();

                    // Calculer les jours restants
                    $now = Carbon::now();
                    $stagiaire->stage->jours_restants = $endDate->diffInDays($now);
                }

                // Assign each stagiaire's projet from the equipe's projets
                foreach ($equipe->projets as $projet) {
                    $stagiaire->projet = $projet;
                }
            }

            $equipe_images = [];
            foreach ($equipe->stagiaires as $stagiaire) {
                if ($stagiaire->image) {
                    array_push($equipe_images, $stagiaire->image);
                }
            }
            $equipe->equipe_images = $equipe_images;

            $progres_total = 0;
            foreach ($equipe->projets as $projet) {
                $progres_total += $projet->avancements()->sum('valeur');

                $avancements_types_count = $projet->avancements()->distinct('type')->count('type');
                $progres_total += round($projet->avancements()->sum('valeur') / $avancements_types_count, 2);
            }

            // Calculating progress outside the loop
            $equipe->progres_total = $equipe->projets->count() > 0 ? $progres_total / $equipe->projets->count() : 0;
        }

        // Returning response outside the loop
        return response()->json($equipes);
    }



}
