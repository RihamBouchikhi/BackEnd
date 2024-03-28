<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taches extends Model
{
    use HasFactory;
    protected $table = 'taches';


    protected $fillable = [
        'titre',
        'description',
        'stagiaire_id',
        'Projet_id',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id');
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'Projet_id');
    }


}
