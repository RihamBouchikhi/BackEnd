<?php

namespace App\Traits;

trait Delete
{
    public function deleteProfile($profile){
        if($profile->delete()){
            return true;
        }
    }
    public function deleteProject($project){  
    $project->interns()->detach();
    if($project->delete()){ 
            return true;
        }
    }
    public function deleteTask($task){
        $project_id = $task->project_id;
        if($task->delete()){ 
            $this->updateProjectStatus($project_id);
                return true;
            }
        }

}