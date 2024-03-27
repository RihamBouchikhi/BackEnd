<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    protected $table = 'attestation';

    use HasFactory;

    protected $fillable = [
        'date',
        'administrateur_id',
        'stagiaire_id',
    ];

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class);
    }
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}
