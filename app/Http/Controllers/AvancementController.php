<?php

namespace App\Http\Controllers;

use App\Models\Avancement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AvancementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avancement = Avancement::all();
        return response()->json($avancement);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $avancement = new Avancement([
            'date' => $request->input('date'),
            'type' => $request->input('type'),
            'text' => $request->input('text'),
            'valeur' => $request->input('valeur'),
            'projet_id' => $request->input('projet_id'),
        ]);
        $avancement->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $avancement = Avancement::find($id) ;
        return response()->json($avancement);
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
        $avancement = Avancement::find($id);
        $avancement->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $avancement = Avancement::find($id);
        $avancement->delete();
        return response()->json('');
    }

    public function getAvancementSumByType($projetId)
    {
        $avancements = Avancement::where('projet_id', $projetId)
            ->select('type', \DB::raw('SUM(valeur) as sum_valeur'))
            ->groupBy('type')
            ->get();

        return response()->json($avancements);
    }

    public function getAvancementByTypeAndDay($projetId)
    {
        $avancementByTypeAndDay = [];

        $types = ['backend', 'frontend', 'conception'];
        $daysOfWeek = [];

        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $daysOfWeek[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        foreach ($types as $type) {
            foreach ($daysOfWeek as $day) {
                $avancements = Avancement::where('projet_id', $projetId)
                    ->where('type', $type)
                    ->whereDate('date', $day)
                    ->get();

                $avancementByTypeAndDay[$day][$type] = $avancements;
            }
        }

        $response = [
            'projet_id' => $projetId,
            'avancementByTypeAndDay' => $avancementByTypeAndDay
        ];

        return response()->json($response);
    }


    public function getAllTimeAvancement($projetId)
    {
        $avancementByTypeAndDay = [];

        $types = ['backend', 'frontend', 'conception'];

        // Get the first day of posting an avancement
        $firstAvancementDate = Avancement::where('projet_id', $projetId)
            ->orderBy('date', 'asc')
            ->value('date');

        $currentDate = Carbon::parse($firstAvancementDate)->startOfDay();
        $today = Carbon::today();

        while ($currentDate <= $today) {
            $day = $currentDate->format('Y-m-d');
            $avancementByTypeAndDay[$day] = [];

            foreach ($types as $type) {
                $avancements = Avancement::where('projet_id', $projetId)
                    ->where('type', $type)
                    ->whereDate('date', $day)
                    ->get();

                $avancementByTypeAndDay[$day][$type] = $avancements;
            }

            $currentDate->addDay();
        }

        $response = [
            'projet_id' => $projetId,
            'avancementByTypeAndDay' => $avancementByTypeAndDay
        ];

        return response()->json($response);
    }



    public function getLastFourAvancements($projet_id)
    {
        $avancements = Avancement::where('projet_id', $projet_id)
            ->orderBy('date', 'desc')
            ->take(4)
            ->get()
            ->map(function ($avancement) {
                $day = date('j', strtotime($avancement->date));
                $month = date('M', strtotime($avancement->date));
                $avancement->month = $month;
                $avancement->day = $day;
                return $avancement;
            });

        return response()->json($avancements);
    }




}
