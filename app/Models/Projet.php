<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $table = 'projet';

    use HasFactory;
    protected $fillable = [
        'sujet',
        'status',
        'description',
        'encadrant_id',

    ];


    

    public function avancements()
    {
        return $this->hasMany(Avancement::class);
    }

    public function encadrant()
    {
        return $this->belongsTo(Encadrant::class, 'encadrant_id');
    }

    public function equipe()
    {
        return $this->hasMany(Equipe::class);
    }

    public function offres()
    {
        return $this->hasMany(Offres::class);
    }

    public function taches()
    {
        return $this->hasMany(Taches::class);
    }
}
