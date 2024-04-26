<?php

namespace App\Traits;
use App\Models\File;

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
           public function deletOldFiles($element,$fileType){
        $oldAvatar = $element->files->where('type','=',$fileType)->first();
        if ($oldAvatar){
            File::find($oldAvatar->id)->delete();
        }
        if ($oldAvatar&&\File::exists(public_path($oldAvatar->url))){
                \File::delete(public_path($oldAvatar->url));
        }
    }
}