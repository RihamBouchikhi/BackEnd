<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $table = 'equipe';

    use HasFactory;
    protected $fillable = [
        'id',
        'nom_equipe',
        'Projet_id',
        'encadrant_id',
    ];


    public function projet()
    {
        return $this->belongsTo(Projet::class, 'Projet_id');
    }
    public function encadrant()
    {
        return $this->belongsTo(Encadrant::class, 'encadrant_id');
    }


}

