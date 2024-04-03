<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulaire extends Model
{
    use HasFactory;

    protected $table = 'formulaire';

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'etablissement',
        'CV',
        'demmande-stage',
        'date-debut',
        'date-fin',
        'Offrestage_id',
        
    ];

    public function stagiaire()
    {
        return $this->hasMany(Stagiaire::class);
    }

    public function offrestage()
    {
        return $this->belongsTo(OffreStage::class, 'Offrestage_id');
    } 
    
}
