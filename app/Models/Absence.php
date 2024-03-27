<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $table = 'absence';

    use HasFactory;
    protected $fillable = [
        'date',
        'etat',
        'justification',
        'stagiaire_id',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}
