<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;
    protected $fillable = [
        'offre_id',
        'user_id',
        "startDate",
        "endDate",
    ];   

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function offer(){
        return $this->belongsTo(Offer::class,'offer_id');
    }
    public function files() {
 	    return $this->morphMany(File::class, 'fileable'); 
	}
}


