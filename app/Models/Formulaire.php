<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulaire extends Model
{
    use HasFactory;

    protected $table = 'formulaire';

    protected $fillable = [
        
        'niveau-etude',
        'etablissement',
        'CV',
        'demmande-stage',
        'date-debut',
        'date-fin',
        'Offres_id',
        
    ];

    public function stagiaire()
    {
        return $this->hasMany(Stagiaire::class);
    }

    public function offres()
    {
        return $this->belongsTo(OffreStage::class, 'Offres_id');
    } 
    
}
