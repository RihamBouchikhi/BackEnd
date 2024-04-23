<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $supervisor_id)
    {
        $request->validate([
            'subject' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'status' => 'required|string',
            'priority' => 'required|string',
            'projectManager' => 'required|exists:interns,id',
        ]);

        $project = Project::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => $request->status,
            'priority' => $request->priority,
            'supervisor_id' => $supervisor_id, 
            'projectManager' => $request->projectManager,
        ]);

        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json('', 204);
    }


    //Assign interns to the specified project.

    public function assignInterns(Request $request, $id)
    {
        $project = Project::findOrFail($id);
    
        $request->validate([
            'interns' => 'array',
            'interns.*' => 'exists:interns,id',
        ]);
    
        $project->interns()->sync($request->input('interns'));
    
        return response()->json($project->fresh('interns'));
    }







}
