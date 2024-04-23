<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Traits\Delete;
use App\Traits\Refactor;
use App\Traits\Store;
use App\Traits\Update;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use Refactor,Store,Update,Delete;
    public function index()
    {
        $projects = Project::all();
        $refactoredProjects = [];
        foreach($projects as $project){
            array_push($refactoredProjects, $this->refactoProject($project));
        }
        return response()->json($refactoredProjects);
    }

    public function store(Request $request)
    {
        $project = $this->storeProjejct($request);
        if (!$project) {
            return response()->json(['message' => "error ,Try Again"], 404);
        }        
        return response()->json($this->refactoProject($project) );
    }
    public function show($id)
    {
        $project = Project::find($id);
         if (!$project) {
            return response()->json(['message' => "undefined project"], 404);
        }
        return response()->json($this->refactoProject($project) );
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
          if (!$project) {
            return response()->json(['message' => "cannot update undefined project!!"], 404);
        }
        $updated = $this->updateProject($request,$project);
        return response()->json($this->refactoProject($updated) );
    }

    public function destroy($id)
    {
        $project = Project::find($id);
          if (!$project) {
            return response()->json(['message' => "cannot delete undefined project!!"], 404);
        }
        $isDeleted = $this->deleteProject($project);
        if ($isDeleted){       
        return response()->json(['message' => 'project deleted succsfully'],200);
    }  
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
