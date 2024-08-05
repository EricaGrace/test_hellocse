<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // le nom de la table ici est spécifié car erreur lors de l'exécution des seeders à cause des conventions de nommage de Laravel
    protected $table = 'profile';

    protected $fillable = [
        'nom', 'prenom', 'image', 'statut',
    ];
}
