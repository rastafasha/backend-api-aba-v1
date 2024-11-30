<?php

namespace Tests\Feature\Insurance;

use Tests\TestCase;
use App\Models\Insurance\Insurance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class InsuranceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test creating a new insurance provider
     */
    public function test_can_create_insurance()
    {
        $insuranceData = [
            'name' => $this->faker->company . ' Insurance',
            'services' => [
                'code' => '97153',
                'provider' => 'BCBA',
                'description' => 'Adaptive behavior treatment',
                'unit_price' => 65.00,
                'hourly_fee' => 130.00,
                'max_allowed' => 40
            ],
            'notes' => [
                'description' => 'Primary insurance provider for ABA therapy services'
            ],
            'payer_id' => '00123',
            'street' => $this->faker->streetAddress,
            'street2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
        ];

        $response = $this->postJson('/api/v2/insurances', $insuranceData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Insurance created successfully'
            ]);

        $this->assertDatabaseHas('insurances', [
            'name' => $insuranceData['name'],
            'payer_id' => $insuranceData['payer_id']
        ]);
    }

    /**
     * Test updating an existing insurance provider
     */
    public function test_can_update_insurance()
    {
        $insurance = Insurance::factory()->create();

        $updatedData = [
            'name' => 'Updated Insurance Name',
            'services' => [
                'code' => '97154',
                'provider' => 'Updated Provider',
                'description' => 'Updated description',
                'unit_price' => 75.00,
                'hourly_fee' => 150.00,
                'max_allowed' => 45
            ],
            'payer_id' => '00124',
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
        ];

        $response = $this->putJson("/api/v2/insurances/{$insurance->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Insurance updated successfully'
            ]);

        $this->assertDatabaseHas('insurances', [
            'id' => $insurance->id,
            'name' => 'Updated Insurance Name',
            'payer_id' => '00124'
        ]);
    }

    /**
     * Test deleting an insurance provider
     */
    public function test_can_delete_insurance()
    {
        $insurance = Insurance::factory()->create();

        $response = $this->deleteJson("/api/v2/insurances/{$insurance->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Insurance deleted successfully'
            ]);

        $this->assertSoftDeleted('insurances', [
            'id' => $insurance->id
        ]);
    }

    /**
     * Test retrieving a single insurance provider
     */
    public function test_can_retrieve_insurance()
    {
        $insurance = Insurance::factory()->create();

        $response = $this->getJson("/api/v2/insurances/{$insurance->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'services',
                    'notes',
                    'payer_id',
                    'street',
                    'street2',
                    'city',
                    'state',
                    'zip',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test insurance validation rules
     */
    public function test_insurance_validation_rules()
    {
        $response = $this->postJson('/api/v2/insurances', [
            // Sending empty data to trigger validation
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test listing insurance providers with filters
     */
    public function test_can_list_insurances_with_filters()
    {
        // Create test insurance providers
        Insurance::factory()->count(2)->create();
        $searchInsurance = Insurance::factory()->create([
            'name' => 'Unique Insurance Name'
        ]);

        // Test basic listing
        $response = $this->getJson('/api/v2/insurances');
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

        // Test with search filter
        $searchResponse = $this->getJson('/api/v2/insurances?name=Unique Insurance Name');
        $searchResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.name', 'Unique Insurance Name');
    }
}