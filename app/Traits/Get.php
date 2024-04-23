<?php

namespace App\Traits;
use App\Models\Admin;
use App\Models\Intern;
use App\Models\Project;
use App\Models\Supervisor;
use App\Models\Task;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Request;

trait Get
{
    use Refactor;
    public function GetAll($role){
        $all = [];
        if ($role === 'admins') {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                $profile = $admin->profile;
                array_push($all, $this->refactorProfile($profile));
            }
            return $all;
        }
        if ($role === 'supervisors') {
            $supervisors = Supervisor::all();
            foreach ($supervisors as $supervisor) {
                $profile = $supervisor->profile;
                array_push($all, $this->refactorProfile($profile));
            }
            return $all;
        }
        if ($role === 'interns') {
            $interns = Intern::all();
            foreach ($interns as $intern) {
                $profile = $intern->profile;
                array_push($all, $this->refactorProfile($profile));
            }
            return $all;
        }
        if ($role === 'users') {
            $users = User::all();
            foreach ($users as $user) {
                $profile = $user->profile;
                array_push($all, $this->refactorProfile($profile));
            }
            return $all;
        }
        if ($role === 'projects') {
            $projects = Project::all();
            foreach ($projects as $project) {
                array_push($all, $this->refactoProject($project));
            }
            return $all;
        }
        if ($role === 'tasks') {
            $tasks = Task::all();
            foreach ($tasks as $task) {
                array_push($all, $this->refactorTask($task));
            }
            return $all;
        }
    }

}