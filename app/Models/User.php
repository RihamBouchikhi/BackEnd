<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'users';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'username',
        'email',
        'password',
        'avatar',
        'role',
    ];


/**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



 // Observer la création d'un utilisateur
 /*
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($utilisateur) 
        {
            // Définir le rôle en fonction du type d'utilisateur
            if ($utilisateur instanceof Stagiaire) {
                $utilisateur->role = 'stagiaire';
            } elseif ($utilisateur instanceof Encadrant) {
                $utilisateur->role = 'encadrant';
            } elseif ($utilisateur instanceof Admin) {
                $utilisateur->role = 'admin';
            }
        });
    }
*/

    // Relation avec les administrateurs
    
    public function administrateur()
    {
        return $this->hasOne(Administrateur::class);
    }
    
    // Relation avec les stagiaires
    public function stagiaire()
    {
        return $this->hasOne(Stagiaire::class);
    }

    // Relation avec les encadrants
    public function encadrant()
    {
        return $this->hasOne(Encadrant::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
