<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable

{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'profile_id',    
    ];
    public function profile(){
        return $this->belongsTo(Profile::class,'profile_id');
    }
}
