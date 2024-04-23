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
}