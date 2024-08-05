<?php

namespace Database\Factories;

use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrateur>
 */
class AdministrateurFactory extends Factory
{

    // Définir le modèle correspondant à cette factory
    protected $model = Administrateur::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array ## les factories servent à générer des données fictives pour aider aux tests
    {
        return [
            'nom' => $this->faker->name, // Génère un nom aléatoire
            'email' => $this->faker->unique()->safeEmail, // Génère un email unique
            'mot_de_passe' => Hash::make('password'), // Génère un mot de passe hashé
        ];
    }
}
