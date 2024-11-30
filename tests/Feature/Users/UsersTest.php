<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_show_endpoint_returns_correct_user()
    {
        // Create multiple users
        $user1 = User::factory()->create(['name' => 'User One']);
        $user2 = User::factory()->create(['name' => 'User Two']);
        $user3 = User::factory()->create(['name' => 'User Three']);

        // Request the second user specifically
        $response = $this->getJson("/api/v2/users/{$user2->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $user2->id,
                    'name' => 'User Two'
                ]
            ]);

        // Verify it's not returning the first user
        $response->assertJsonMissing([
            'data' => [
                'id' => $user1->id,
                'name' => 'User One'
            ]
        ]);
    }
}
