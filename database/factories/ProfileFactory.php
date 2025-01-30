<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{

    // Définir le modèle correspondant à la factory
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName, // Génère un nom de famille aléatoire
            'prenom' => $this->faker->firstName, // Génère un prénom aléatoire
            'image' => $this->faker->imageUrl(400, 300, 'people', true, 'Faker'), // Génère un chemin d'image fictif
            'statut' => $this->faker->randomElement(['inactif', 'en attente', 'actif']), // Génère un statut aléatoire parmi les valeurs spécifiées
        ];
    }
}
