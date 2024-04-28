<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        "academicLevel",
        "establishment",
        "startDate",
        "endDate",
        "profile_id"
    ];
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function demands(){
        return $this->hasMany(Demand::class);
    }
    public function files() {
 	    return $this->morphMany(File::class, 'fileable'); 
	}
     protected static function boot()
    {
        parent::boot();
            static::deleting(function ($user) {
                $user->files()->delete();          
            });

    }
}
