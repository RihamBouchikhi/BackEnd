<?php

namespace App\Traits;
use App\Models\Project;


trait Update
{
    public function updateProfile($data,$profile){      
        $validatedData = $data->validate([
                'email' => 'email|unique:profiles,email',
                'firstName' => 'string',
                'lastName' =>  'string',
                'phone' =>      'string',
                'password' =>   'string'
                ]);
     
        $profile->update($validatedData);
        if ($data->role=='user') {
            $user = $profile->user;
             $updateData = array_filter([
            'academicLevel' => $data['academicLevel'] ?? null,
            'establishment' => $data['establishment'] ?? null,
            'startDate' => $data['startDate'] ?? null,
            'endDate' => $data['endDate'] ?? null,
        ]);
            $user->update($updateData);
        }
        if ($data->role=='intern') {
            $intern = $profile->intern;
             $updateData = array_filter([
            'academicLevel' => $data['academicLevel'] ?? null,
            'establishment' => $data['establishment'] ?? null,
            'startDate' => $data['startDate'] ?? null,
            'endDate' => $data['endDate'] ?? null,
        ]);
            $intern->update($updateData);
        }
        return $profile;
    }

    public function updateProject($data,$project){
        $validatedProject = $data->validate([
            'subject' => 'string',
            'description' => 'string',
            'startDate' => 'date',
            'endDate' => 'date',
            'status' => 'string',
            'priority' => 'in:Low,Medium,High,None',
            'supervisor_id' => 'exists:supervisors,id',
            'intern_id' => 'nullable|exists:interns,id',
            'teamMembers' => 'array|exists:interns,id',
        ]);
        $project->update($validatedProject);
        if ($data->has('teamMembers')){
            $project->interns()->detach();
            $project->interns()->attach($data['teamMembers']);
        }
        return $project;
    }

    public function updateTask($request,$task){
        $validatedData = $request->validate([
        'title' => 'max:255',
        'description' => '',
        'dueDate' => 'date',
        'priority' => 'in:Low,Medium,High,None',
        'status' => 'in:To Do,Done,In Progress',
        'intern_id' => 'nullable|exists:interns,id',
        'project_id' => 'exists:projects,id',
    ]);
        $task->update($validatedData);
        $this->updateProjectStatus($task->project_id);
        return $task;
    }

    public function updateProjectStatus($project_id){
        $project = Project::find($project_id);
        $todoCount = $project->tasks()->where('status', 'To Do')->count();
        $progressCount = $project->tasks()->where('status', 'In Progress')->count();
        $doneCount = $project->tasks()->where('status', 'Done')->count();

        if ($doneCount > 0 && $todoCount == 0 && $progressCount == 0) {
            $project->status = "Completed";
        } elseif ($progressCount > 0 || $doneCount > 0) {
            $project->status = "In Progress";
        } else {
            $project->status = "Not Started";
        }

        $project->save();
    }
}