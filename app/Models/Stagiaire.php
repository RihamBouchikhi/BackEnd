<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Stagiaire extends Authenticatable
{
    protected $table = 'stagiaire';

    use HasApiTokens, HasFactory, Notifiable;

    // Par défaut, le modèle Stagiaire hérite de tous les attributs et relations du modèle user

    // Les propriétés  spécifiques aux stagiaires
    protected $fillable = [
        'RapportStage',
        'ProjetFinale',
        //'Attestation_id',
        'Form_id',
        'Equipe_id',

    ];

    /*    
    public function attestaion()
    {
        return $this->belongsTo(Attestation::class, 'Attestation_id');
    }
    */
    public function formulaire()
    {
        return $this->belongsTo(Formulaire::class, 'Form_id');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'Equipe_id');
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function taches()
    {
        return $this->hasMany(Taches::class);
    }
}

