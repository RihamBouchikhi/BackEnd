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

trait Store
{
    public function storeProfile($request)
    {
        $validatedProfile = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email|max:255',
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols(),
                'confirmed',
            ]
        ]);
            $profile = new Profile;
            $profile->firstName = $validatedProfile['firstName'];
            $profile->lastName = $validatedProfile['lastName'];
            $profile->email = $validatedProfile['email'];
            $profile->phone = $validatedProfile['phone'];
            $profile->password = bcrypt($validatedProfile['password']);
            $profile->role = $request->role;
            $profile->save();
        if ($request->role == 'user') {
            $validatedUser = $request->validate([
                'academicLevel' => 'required|string',
                'establishment' => 'required|string',
                'startDate' => 'required',
                'endDate' => 'required',
            ]);
            $user = new User;
            $user->profile_id = $profile->id;
            $user->academicLevel = $validatedUser['academicLevel'];
            $user->establishment = $validatedUser['establishment'];
            $user->startDate = $validatedUser['startDate'];
            $user->endDate = $validatedUser['endDate'];
            $user->save();
        }
        if ($request->role == 'admin') {
           $admin = new Admin;
            $admin->profile_id = $profile->id;
            $admin->save();
        }
        if ($request->role == 'supervisor') {
            $supervisor = new Supervisor;
            $supervisor->profile_id = $profile->id;
            $supervisor->save();
        }
        if ($request->role == 'intern') {
                $validatedIntern = $request->validate([
                'academicLevel' => 'required|string',
                'establishment' => 'required|string',
                'startDate' => 'required',
                'endDate' => 'required',
            ]);
            $intern = new Intern;
            $intern->profile_id = $profile->id;
            $intern->academicLevel = $validatedIntern['academicLevel'];
            $intern->establishment = $validatedIntern['establishment'];
            $intern->startDate = $validatedIntern['startDate'];
            $intern->endDate = $validatedIntern['endDate'];
            $intern->save();
        }
        return $profile;
    }
    public function storeProjejct($request){
        $validatedProject = $request->validate([
            'subject' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'status' => 'required|string',
            'priority' => 'required|string',
            'supervisor_id' => 'required|exists:supervisors,id',
            'projectManager' => 'required|exists:interns,id',
            'tasks' => 'array',
            'teamMembers' => 'array|exists:interns,id',
        ]);
            $project = new Project;
            $project->subject = $validatedProject['subject'];
            $project->description = $validatedProject['description'];
            $project->startDate = $validatedProject['startDate'];
            $project->endDate = $validatedProject['endDate'];
            $project->status = $validatedProject['status'];
            $project->priority = $validatedProject['priority'];
            $project->supervisor_id = $validatedProject['supervisor_id'];
            $project->intern_id = $validatedProject['projectManager']; 
            $project->save();
    foreach ($validatedProject['teamMembers'] as $teamMemberId) {
        $project->interns()->attach($teamMemberId);
    }
    foreach ($validatedProject['tasks'] as $taskData) {
        $task = new Task;
        $task->title = $taskData['title'];
        $task->description = $taskData['description'];
        $task->dueDate = $taskData['dueDate'];
        $task->priority = $taskData['priority'];
        $task->status = $taskData['status'];
        $task->intern_id = $taskData['intern_id']; 
        $task->project_id = $project->id; 
        $task->save();
    }
    return $project;
    }
}