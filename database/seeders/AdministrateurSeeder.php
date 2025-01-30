<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrateur;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Utiliser la factory pour créer 50 instances d'administrateurs
        Administrateur::factory()->count(50)->create();
        
    }
}
