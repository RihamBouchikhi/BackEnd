<?php

namespace App\Traits;

trait Refactor
{
    public function refactorProfile($profile){
        if ($profile->role==='user'){
            $user = $profile->user;
            $demandesData = $user->demandes;
            $filesData = $user->files;
            $demandes = [];
            $files = [];
            foreach($demandesData as $demande){
                $offerData = $demande->offer;
                $userData = $demande->user;
                $filesArray = $demande->files;
                $files = [];
                foreach ($filesArray as $file) {
                    array_push($files, ['name'=>$file->name,'url'=>$file->url,'type'=>$file->type]);
                }
                $offer = ["title" => $offerData->title];
                $user = ["fullName" => $userData->fullName];
                array_push($array,['user'=>$user,'offer'=>$offer,"startDate"=>$demande->startDate,"endDate"=>$demande->endDate,'files'=>$files]);
            }
            foreach($filesData as $file){
                array_push($files, ['name' => $file->name, 'url'=>$file->url,'type'=>$file->type]);
            }
            $refactored = [
                "fullName"=>$profile->fullName,
                "phone"=>$profile->phone,
                "email"=>$profile->email,
                "role"=>$profile->role,
                "academicLevel" => $user->academicLevel,
                "etablissement" => $user->etablissement,
                "startDate" => $user->startDate,
                "endDate" => $user->endDate,
                "date" => $user->date,
                "demandes"=>$demandes,
                "files"=>$files
            ];
        return $refactored;
        };
        if ($profile->role==='admin'){
            $refactored = [
                "fullName"=>$profile->fullName,
                "phone"=>$profile->phone,
                "email"=>$profile->email,
                "role"=>$profile->role,
            ];
            return $refactored;
        } ;
        if ($profile->role==='supervisor'){
            $supervisor = $profile->supervisor;
            $projectsData = $supervisor->projects;
            $projects = [];
            foreach($projectsData as $project){
                $supervisor = $project->supervisor;
                $teamMembersData = $project->interns;
                $projectManager = $project->projectManager;
                $teamMembers=[];
                foreach($teamMembersData as $teamMember){
                    array_push($teamMembers, $teamMember->id);
                }
                array_push($projects, ['subject'=>$project->subject,"startDate"=>$project->startDate,
                "endDate"=>$project->endDate,"status"=>$project->status,"priority"=>$project->priority,
                'description'=>$project->description,'projectManager'=>$projectManager,
                'supervisor' => $supervisor->id,'teamMembres'=>$teamMembers]);
            }
            $refactored = [
                "fullName"=>$profile->fullName,
                "phone"=>$profile->phone,
                "email"=>$profile->email,
                "role"=>$profile->role,
                "projects"=>$projects
            ];
            return $refactored;
        };
        if($profile->role==='intern'){
            $intern = $profile->intern;
            $projectsData = $intern->projects;
            $projects = [];
            foreach($projectsData as $project){
                $supervisor = $project->supervisor;
                $teamMembersData = $project->interns;
                $projectManager = $project->projectManager;
                $teamMembers=[];
                foreach($teamMembersData as $teamMember){
                    array_push($teamMembers, $teamMember->id);
                }
                array_push($projects, ['subject'=>$project->subject,"startDate"=>$project->startDate,
                "endDate"=>$project->endDate,"status"=>$project->status,"priority"=>$project->priority,
                'description'=>$project->description,'projectManager'=>$projectManager,
                'supervisor' => $supervisor->id,'teamMembres'=>$teamMembers]);
            }
            $filesData = $intern->files;
            $files = [];
            foreach($filesData as $file){
                array_push($files, ['name' => $file->name, 'url'=>$file->url,'type'=>$file->type]);
            }
            $tasksData = $intern->tasks;
            $tasks = [];
            foreach($tasksData as $task){
                array_push($tasks, ['title' => $task->title, 'description'=>$task->description,'dueDate'=>$task->dueDate,'priority'=>$task->priority,'status'=>$task->status]);
            }
            $refactored = [
                "fullName"=>$profile->fullName,
                "phone"=>$profile->phone,
                "email"=>$profile->email,
                "role"=>$profile->role,
                "projects"=>$projects,
                "files"=>$files,
                "tasks"=>$tasks,
            ];
            return $refactored;
        }
       
  }
}