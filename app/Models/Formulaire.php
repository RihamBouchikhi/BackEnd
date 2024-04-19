<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulaire extends Model
{
    use HasFactory;

    protected $table = 'formulaire';

    protected $fillable = [
        
        'niveau_etude',
        'etablissement',
        'CV',
        'demande_stage',
        'date_debut',
        'date_fin',
        'Offres_id',
        
    ]; 

    public function stagiaire()
    {
        return $this->hasMany(Stagiaire::class);
    }

    public function offres()
    {
        return $this->belongsTo(Offres::class, 'Offres_id');
    } 
    
}
