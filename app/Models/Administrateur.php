<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'email', 'mot_de_passe',
    ];

    protected $hidden = [
        'mot_de_passe', 'remember_token',
    ];
}
