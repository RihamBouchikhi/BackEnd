<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Encadrant extends Authenticatable
{
    protected $table = 'encadrant';

    use HasApiTokens, HasFactory, Notifiable;

     // Par défaut, le modèle Encadrant hérite de tous les attributs et relations du modèle Utilisateur
    protected $fillable = [
        'user_id',
        'specialite',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projet()
    {
        return $this->hasMany(Projet::class);
    }

    public function equipe()
    {
        return $this->hasMany(Equipe::class);
    }
}
