<?php

namespace App\Traits;
use App\Models\Admin;
use App\Models\Intern;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Supervisor;
use App\Models\Task;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Request;

trait Update
{
    public function updateProfile($data,$profile){      
        $validatedData = $data->validate([
                'email' => 'email|unique:profiles,email',
                ]);
        $updateData = array_filter([
            'firstName' => $data['firstName'] ?? null,
            'lastName' => $data['lastName'] ?? null,
            'email' => $validatedData['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'password' => isset($data['password']) ? bcrypt($data['password']) : null,
        ]);
        $profile->update($updateData);
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
            'priority' => 'string',
            'supervisor_id' => 'exists:supervisors,id',
            'projectManager' => 'exists:interns,id',
            'teamMembers' => 'array',
        ]);
        $project->subject = $validatedProject['subject'];
        $project->description = $validatedProject['description'];
        $project->startDate = $validatedProject['startDate'];
        $project->endDate = $validatedProject['endDate'];
        $project->status = $validatedProject['status'];
        $project->priority = $validatedProject['priority'];
        $project->supervisor_id = $validatedProject['supervisor_id']; // replace with appropriate supervisor ID
        $project->intern_id = $validatedProject['projectManager']; // replace with appropriate supervisor ID
        $project->save();
        if ($data->has('teamMembers')){
            $project->interns()->detach();
            $project->interns()->attach($validatedProject['teamMembers']);
        }
        return $project;
    }

    public function updateTask($request,$task){
        $validatedData = $request->validate([
        'title' => 'max:255',
        'description' => '',
        'dueDate' => 'date',
        'priority' => 'in:Low,Medium,High',
        'status' => 'in:To Do,Done,In Progress',
        'intern_id' => 'exists:interns,id',
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