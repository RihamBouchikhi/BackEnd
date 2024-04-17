<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demmande extends Model
{
    use HasFactory;

    protected $fillable = [
        'offres_id',
        'user_id',
    ];   

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function OffreStage()
    {
        return $this->belongsTo(Offres::class, 'offres_id');
    }
}


