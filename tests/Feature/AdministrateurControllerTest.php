<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;

class AdministrateurControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register(): void
    {
        $response = $this->postJson('/api/register', [
            'nom' => 'Admin',
            'email' => 'admin@example.com',
            'mot_de_passe' => 'password',
            'mot_de_passe_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('administrateurs', [
            'email' => 'admin@example.com',
        ]);
    }

    public function test_login()
    {
        $admin = Administrateur::factory()->create([
            'mot_de_passe' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $admin->email,
            'mot_de_passe' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type']);
    }

    public function test_logout()
    {
        $admin = Administrateur::factory()->create();
        $token = $admin->createToken('auth_token')->plainTextToken;
        $this->actingAs($admin, 'sanctum');
    
        $response = $this->postJson('/api/logout', [], ['Authorization' => 'Bearer ' . $token]);
    
        $response->assertStatus(200);
    }
    
}
