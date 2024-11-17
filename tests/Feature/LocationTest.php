<?php

namespace Tests\Feature\Location;

use Tests\TestCase;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LocationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test creating a new location
     */
    public function test_can_create_location()
    {
        $locationData = [
            'title' => $this->faker->company,
            'address' => $this->faker->address,
            'phone1' => $this->faker->phoneNumber,
            'phone2' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'email' => $this->faker->safeEmail,
            'telfax' => $this->faker->phoneNumber,
        ];

        $response = $this->postJson('/api/v2/locations', $locationData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Location created successfully'
            ]);

        $this->assertDatabaseHas('locations', [
            'title' => $locationData['title'],
            'email' => $locationData['email']
        ]);
    }

    /**
     * Test updating an existing location
     */
    public function test_can_update_location()
    {
        $location = Location::factory()->create();

        $updatedData = [
            'title' => 'Updated Location Name',
            'address' => $this->faker->address,
            'phone1' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'email' => $this->faker->safeEmail,
        ];

        $response = $this->putJson("/api/v2/locations/{$location->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Location updated successfully'
            ]);

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'title' => 'Updated Location Name'
        ]);
    }

    /**
     * Test deleting a location
     */
    public function test_can_delete_location()
    {
        $location = Location::factory()->create();

        $response = $this->deleteJson("/api/v2/locations/{$location->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Location deleted successfully'
            ]);

        $this->assertSoftDeleted('locations', [
            'id' => $location->id
        ]);
    }

    /**
     * Test retrieving a single location
     */
    public function test_can_retrieve_location()
    {
        $location = Location::factory()->create();

        $response = $this->getJson("/api/v2/locations/{$location->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'title',
                    'address',
                    'phone1',
                    'phone2',
                    'city',
                    'state',
                    'zip',
                    'email',
                    'telfax',
                    'avatar',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test location validation rules
     */
    public function test_location_validation_rules()
    {
        $response = $this->postJson('/api/v2/locations', [
            // Sending empty data to trigger validation
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    /**
     * Test listing locations with filters
     */
    public function test_can_list_locations_with_filters()
    {
        // Create test locations
        Location::factory()->count(2)->create();
        $searchLocation = Location::factory()->create([
            'title' => 'Unique Location Name',
            'city' => 'Test City'
        ]);

        // Test basic listing
        $response = $this->getJson('/api/v2/locations');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ]
            ]);

        // Test with title filter
        $searchResponse = $this->getJson('/api/v2/locations?title=Unique Location Name');
        $searchResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.title', 'Unique Location Name');

        // Test with city filter
        $cityFilterResponse = $this->getJson('/api/v2/locations?city=Test City');
        $cityFilterResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.city', 'Test City');
    }
}
