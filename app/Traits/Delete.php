<?php

namespace App\Traits;
use App\Models\Admin;
use App\Models\Intern;
use App\Models\Profile;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

trait Delete
{
    public function deleteProfile($id){
        $profile = Profile::find($id);
        if($profile->delete()){
            return true;
        }
    }
}