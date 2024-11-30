<?php

namespace Tests\Feature\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BipTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $client;
    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();

        // Create client and doctor users for all tests
        $this->client = User::factory()->create();
        $this->doctor = User::factory()->create();
    }

    /**
     * Test creating a new BIP
     */
    public function test_can_create_bip()
    {
        $client = User::factory()->create();
        $doctor = User::factory()->create();

        $bipData = [
            'client_id' => $client->id,
            'patient_identifier' => 'PAT' . $this->faker->unique()->numberBetween(1000, 9999),
            'doctor_id' => $doctor->id,
            'type_of_assessment' => $this->faker->numberBetween(1, 5),
            'background_information' => $this->faker->paragraph(),
            'maladaptives' => [
                'tantrums' => true,
                'aggression' => false,
                'self_stimming' => true
            ],
            'interventions' => [
                'token_economy' => true,
                'positive_reinforcement' => true
            ],
            'documents_reviewed' => ['doc1', 'doc2', 'doc3']
        ];

        $response = $this->postJson('/api/v2/bips', $bipData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'BIP created successfully'
            ]);

        $this->assertDatabaseHas('bips', [
            'client_id' => $client->id,
            'patient_identifier' => $bipData['patient_identifier'],
            'doctor_id' => $doctor->id
        ]);
    }

    /**
     * Test updating an existing BIP
     */
    public function test_can_update_bip()
    {
        $bip = Bip::factory()->create([
            'client_id' => $this->client->id,
            'doctor_id' => $this->doctor->id,
        ]);

        $updatedData = [
            'client_id' => $this->client->id,
            'type_of_assessment' => 4,
            'background_information' => 'Updated background information',
            'maladaptives' => [
                'tantrums' => false,
                'aggression' => true
            ]
        ];

        $response = $this->putJson("/api/v2/bips/{$bip->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'BIP updated successfully'
            ]);

        $this->assertDatabaseHas('bips', [
            'id' => $bip->id,
            'type_of_assessment' => 4,
            'background_information' => 'Updated background information'
        ]);
    }

    /**
     * Test deleting a BIP
     */
    public function test_can_delete_bip()
    {
        $bip = Bip::factory()->create();

        $response = $this->deleteJson("/api/v2/bips/{$bip->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'BIP deleted successfully'
            ]);

        $this->assertSoftDeleted('bips', [
            'id' => $bip->id
        ]);
    }


    /**
     * Test BIP validation rules
     */
    public function test_bip_validation_rules()
    {
        $response = $this->postJson('/api/v2/bips', [
            // Sending empty data to trigger validation
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type_of_assessment', 'client_id']);
    }

    /**
     * Test listing BIPs with filters
     */
    public function test_can_list_bips_with_filters()
    {
        $doctor = User::factory()->create();
        $patient_identifier = 'PAT1234';

        // Create test BIPs
        Bip::factory()->count(2)->create();
        Bip::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_identifier' => $patient_identifier
        ]);

        // Test with doctor filter
        $doctorFilterResponse = $this->getJson("/api/v2/bips?doctor_id={$doctor->id}");
        $doctorFilterResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.doctor_id', $doctor->id);

        // Test with patient filter
        $patientFilterResponse = $this->getJson("/api/v2/bips?patient_id={$patient_identifier}");
        $patientFilterResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.patient_id', $patient_identifier);

        // Test with date range filter
        $dateFilterResponse = $this->getJson('/api/v2/bips?date_from=2024-01-01&date_to=2024-12-31');
        $dateFilterResponse->assertStatus(200);
    }
}
