<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Administrateur;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store(): void
    {
        $admin = Administrateur::factory()->create();
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/profiles', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
            'statut' => 'actif',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('profile', [
            'nom' => 'Doe',
            'prenom' => 'John',
        ]);
    }

    public function test_update()
    {
        $admin = Administrateur::factory()->create();
        $profile = Profile::factory()->create(['statut' => 'en attente']);
        $this->actingAs($admin, 'sanctum');

        $response = $this->putJson("/api/profiles/{$profile->id}", [
            'nom' => 'Doe',
            'prenom' => 'John',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
            'statut' => 'actif',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('profile', [
            'id' => $profile->id,
            'statut' => 'actif',
        ]);
    }

    public function test_destroy()
    {
        $admin = Administrateur::factory()->create();
        $profile = Profile::factory()->create();
        $this->actingAs($admin, 'sanctum');

        $response = $this->deleteJson("/api/profiles/{$profile->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('profile', ['id' => $profile->id]);
    }

    public function test_index()
    {
        Profile::factory()->create(['statut' => 'actif']);
        Profile::factory()->create(['statut' => 'en attente']);

        $response = $this->getJson('/api/profiles');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
