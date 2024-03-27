<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    use HasFactory;

    protected $fillable = [
        'emetteur_id',
        'recepteur_id',
        'contenu',
        'date-envoi',
        'est_lu',

    ];

    public function user()
    {
        return $this->belongsTo(User::class,'emetteur_id');
        return $this->belongsTo(User::class,'recepteur_id');
    }
}
