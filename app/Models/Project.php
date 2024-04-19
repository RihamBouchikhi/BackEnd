<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject',
        'description',
        "startDate","endDate",
        'status',
        'priority',
        'supervisor_id',
        "projectManger"
    ];

    public function supervisor(){
        return $this->belongsTo(Supervisor::class,'supervisor_id');
    }
    public function projectManger(){
        return $this->belongsTo(Intern::class,'projectManger');
    }
    public function taskes(){
        return $this->hasMany(Taske::class);
    }
}
