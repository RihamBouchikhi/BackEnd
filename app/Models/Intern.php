<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Intern extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'project_id',
        'profile_id',
        'projectLink',
        'academicLevel',
        'establishment',
        "startDate",
        'endDate'
    ];

      public function profile(){
        return $this->belongsTo(Profile::class,'profile_id');
    }
      public function projects(){
        return $this->belongsToMany(Project::class,'interns_projects', 'intern_id', 'project_id');
    }
    public function managedBy(){
        return $this->belongsTo(Project::class);
    }
    public function tasks()
    {
        return $this->hasMany(Taske::class,'intern_id');
    }
    public function files() {
 	    return $this->morphMany(File::class, 'fileable'); 
	}

}

