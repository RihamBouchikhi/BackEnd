<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offres extends Model
{
    use HasFactory;

    protected $table = 'offres';

    protected $fillable = [

        'titre',
        'description',
        'domaine',
        'dure',
        'Admin_id',
        'Projet_id',
        
        
    ];

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class, 'Admin_id');
    }
    
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'Projet_id');
    }


}
