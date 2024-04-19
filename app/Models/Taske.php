<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taske extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'dueDate',
        'priority',
        'status',
        'intern_id',
        'projet_id',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class,'intern_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'projet_id');
    }


}
