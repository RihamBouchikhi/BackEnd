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

    // Par défaut, le modèle Stagiaire hérite de tous les attributs et relations du modèle user

    // Les propriétés  spécifiques aux stagiaires
    protected $fillable = [
        'project_id',
        'person_id',
        'projectLink',

    ];

      public function person(){
        return $this->belongsTo(Person::class,'person_id');
    }
    public function taskes()
    {
        return $this->hasMany(Taske::class,'intern_id');
    }
    public function files() {
 	    return $this->morphMany(File::class, 'fileable'); 
	}
}

