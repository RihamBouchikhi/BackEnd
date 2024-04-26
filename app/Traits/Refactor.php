<?php
namespace App\Traits;

trait Refactor
{
    public function refactorProfile($profile){
        $avatar = $profile->files->where('type','=','avatar')->first();
        if($avatar){
            $files[] = ['url'=>asset($avatar->url),'type'=>'avatar'];
        }
        if ($profile->role==='user'){
            $user = $profile->user;
            $demandsData = $user->demands;
            $demands = [];
            foreach($demandsData as $demand){
                $demands[]=$demand->id;
            } 
            $refactored = [
                "id"=>$user->id,
                "profile_id"=>$profile->id,
                "firstName"=>$profile->firstName,
                "lastName"=>$profile->lastName,
                "email"=>$profile->email,
                "phone"=>$profile->phone,
                "role"=>$profile->role,
                "academicLevel" => $user->academicLevel,
                "establishment" => $user->establishment,
                "demands"=>$demands,
                "files"=>$files??[]
            ];
        return $refactored;
        };
        if ($profile->role==='admin'){
            $admin = $profile->admin;
            $refactored = [
                "id"=>$admin->id,
                "profile_id"=>$profile->id,
                "firstName"=>$profile->firstName,
                "lastName"=>$profile->lastName,
                "email"=>$profile->email,
                "phone"=>$profile->phone,
                "role"=>$profile->role,
                "files"=>$files??[],
            ];
            return $refactored;
        } ;
        if ($profile->role==='supervisor'){
            $supervisor = $profile->supervisor;
            $projectsData = $supervisor->projects;
            $projects = [];
            foreach($projectsData as $project){
                array_push($projects, $project->id);
            }
            $refactored = [
                "id"=>$supervisor->id,
                "profile_id"=>$profile->id,
                "firstName"=>$profile->firstName,
                "lastName"=>$profile->lastName,
                "email"=>$profile->email,
                "phone"=>$profile->phone,
                "role"=>$profile->role,
                "projects"=>$projects,
                "files"=>$files??[]
            ];
            return $refactored;
        };
        if($profile->role==='intern'){
            $intern = $profile->intern;
            $projectsData = $intern->projects;
            $attestation = $profile->files->where('type','=','attestation')->first();
            if($attestation){
                $files[] = array_push($files, ['url'=>asset($attestation->url),'type'=>'attestation']);
            }
            $projects = [];
            foreach($projectsData as $project){
                $projects[]=$project->id;
            }
            $tasksData = $intern->tasks;
            $tasks = [];
            foreach($tasksData as $task){
                $tasks[]=$this->refactorTask($task);
            }
            $refactored = [
                "id"=>$intern->id,
                "profile_id"=>$profile->id,
                "firstName"=>$profile->firstName,
                "lastName"=>$profile->lastName,
                "email"=>$profile->email,
                "phone"=>$profile->phone,
                "role"=>$profile->role,
                "projects"=>$projects,
                "academicLevel" => $intern->academicLevel,
                "establishment" => $intern->establishment,
                "startDate" => $intern->startDate,
                "endDate" => $intern->endDate,
                "files"=>$files??[],
                "tasks"=>$tasks,
            ];
            return $refactored;
        }
    }
    public function refactoProject($project){
        $supervisor = $project->supervisor;
        $projectManager = $project->projectManager;
        $teamMembersData = $project->interns;
        $teamMembers=[];
        foreach($teamMembersData as $teamMember){
            array_push($teamMembers, $teamMember->id);
          }
        $tasksData = $project->tasks;
        $tasks = [];
        foreach($tasksData as $task){
            array_push($tasks,$this->refactorTask($task));
            }
        return [
            'id'=>$project->id,
            'subject'=>$project->subject,
            "startDate"=>$project->startDate,
            "endDate"=>$project->endDate,
            "created_at"=>$project->created_at,
            "updated_at"=>$project->updated_at,
            "status"=>$project->status,
            "priority"=>$project->priority,
            'description'=>$project->description,
            'projectManager'=>!$projectManager?null:$projectManager->id,
            'supervisor' => $supervisor->id,
            'teamMembers'=>$teamMembers,'tasks'=>$tasks];
    }
    public function refactorTask($task){
            $intern = $task->intern;
            if(!$intern){
                $intern = 'None';
            }else{
                $profile = $intern->profile;
                $intern = [
                    "id" => $intern->id,
                    "profile_id" => $profile->id,
                    "firstName" => $profile->firstName,
                    "lastName" => $profile->lastName,
                    "email" => $profile->email
                ];
            }
            return [
                    "id"=> $task->id,
                    "project"=> $task->project_id,
                    "title"=>$task->title,
                    'description'=>$task->description,
                    'dueDate'=>$task->dueDate,
                    'priority'=>$task->priority,
                    'status'=>$task->status,
                    'assignee'=>$intern
                ];
    }
    public function refactorOffer($offer){
        $demandsData = $offer->demands;
        $demands = [];
        foreach($demandsData as $demand){
            array_push($demands,$demand->id);
        }
        return [
            "id"=> $offer->id,
            "title"=>$offer->title,
            'description'=>$offer->description,
            "sector"=> $offer->sector,
            'experience'=>$offer->experience,
            'skills'=>$offer->skills,
            'direction'=>$offer->direction,
            'duration'=>$offer->duration,
            'type'=>$offer->type,
            'visibility'=>$offer->visibility,
            'status'=>$offer->status,
            'city'=>$offer->city,
            'publicationDate'=>$offer->created_at,
            'demands'=>$demands
            ];
    }
    public function refactorDemand($demand){
        $offerData = $demand->offer;
        $profile = $demand->user->profile;
        $user = $this->refactorProfile($profile);
        $offer = $this->refactorOffer($offerData);
        $filesData = $demand->files;
        $files = [];
         foreach($filesData as $file){
                array_push($files, ['url'=>asset($file->url),'type'=>$file->type]);
            }
        return [
            "id"=> $demand->id,
            "offer"=> $offer,
            "user"=> $user,
            "startDate"=>$demand->startDate,
            "endDate"=>$demand->endDate,
            "files"=>$files
        ];
    }
}