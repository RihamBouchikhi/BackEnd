<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mdp_tokens extends Model
{
    protected $table = 'mdp_tokens';

    use HasFactory;
    protected $fillable = [
        'user_id',
        'token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
