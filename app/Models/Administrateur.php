<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Administrateur extends Authenticatable

{
    protected $table = 'administrateur';

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function offres()
    {
        return $this->hasMany(Offres::class);
    }
    public function attestation()
    {
        return $this->hasMany(Attestation::class);
    } 
}
