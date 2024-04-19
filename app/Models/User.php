<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'users';

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "academicLevel",
        "establishment",
        "startDate",
        "endDate",
        "profile_id"
    ];

    public function profile(){
        return $this->belongsTo(Profile::class,'profile_id');
    }
    public function demandes(){
        return $this->hasMany(Demande::class,'user_id');
    }
     public function files() {
 	    return $this->morphMany(File::class, 'fileable'); 
	}

}
