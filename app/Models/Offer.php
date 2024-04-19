<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'domaine',
        'dure',
        'admin_id',
        'projet_id',
    ];
    
    public function demandes(){
        return $this->hasMany(Demande::class,'offer_id');
    }

}
