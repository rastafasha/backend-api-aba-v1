<?php

namespace Tests\Feature\Patient;

use App\Models\Insurance\Insurance;
use App\Models\Location;
use Tests\TestCase;
use App\Models\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PatientTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $insurance;
    protected $location;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test insurance provider
        $this->insurance = Insurance::factory()->create();
        $this->location = Location::factory()->create();
    }

    /**
     * Test creating a new patient
     */
    public function test_can_create_patient()
    {
        $patientData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gender' => 1,
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'status' => 'active',
            'insurer_id' => $this->insurance->id,
            'location_id' => $this->location->id,
            'telehealth' => false,
            'pay' => false
        ];


        $response = $this->postJson('/api/v2/patients', $patientData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Patient created successfully'
            ]);

        $this->assertDatabaseHas('patients', [
            'first_name' => $patientData['first_name'],
            'email' => $patientData['email']
        ]);
    }

    /**
     * Test creating a new patient with pa_assessments
     */
    public function test_can_create_patient_with_pa_assessments()
    {
        $patientData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gender' => 1,
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'status' => 'active',
            'language' => $this->faker->randomElement(['English', 'Spanish', 'French']),
            'insurer_id' => $this->insurance->id,
            'location_id' => $this->location->id,
            'telehealth' => false,
            'pay' => false,
            'pa_assessments' => [
                [
                    'pa_services' => 'Behavioral Analysis',
                    'cpt' => '97151',
                    'n_units' => 2,
                    'start_date' => '2024-01-01',
                    'end_date' => '2024-02-01'
                ],
                [
                    'pa_services' => 'BCBA Supervision',
                    'cpt' => '97155',
                    'n_units' => 1,
                    'start_date' => '2024-01-01',
                    'end_date' => '2024-02-01'
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/patients', $patientData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Patient created successfully'
            ]);

        $this->assertDatabaseHas('patients', [
            'first_name' => $patientData['first_name'],
            'email' => $patientData['email']
        ]);

        $this->assertDatabaseHas('pa_services', [
            'pa_services' => 'Behavioral Analysis',
            'cpt' => '97151',
            'n_units' => 2,
            'start_date' => '2024-01-01',
            'end_date' => '2024-02-01',
        ]);

        $this->assertDatabaseHas('pa_services', [
            'pa_services' => 'BCBA Supervision',
            'cpt' => '97155',
            'n_units' => 1,
            'start_date' => '2024-01-01',
            'end_date' => '2024-02-01',
        ]);
    }


    /**
     * Test updating an existing patient
     */
    public function test_can_update_patient()
    {
        $patient = Patient::factory()->create([
            'insurer_id' => $this->insurance->id,
            'location_id' => $this->location->id
        ]);

        $updatedData = [
            'first_name' => 'Updated Name',
            'last_name' => 'Updated Last Name',
            'email' => 'updated@example.com',
            'phone' => $this->faker->phoneNumber,
            'gender' => 1,
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'status' => 'active',
            'insurer_id' => $this->insurance->id,
            'location_id' => $this->location->id,
            'telehealth' => false,
            'pay' => false
        ];

        $response = $this->putJson("/api/v2/patients/{$patient->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Patient updated successfully'
            ]);

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'first_name' => 'Updated Name',
            'last_name' => 'Updated Last Name',
            'email' => 'updated@example.com'
        ]);
    }

    /**
     * Test deleting a patient
     */
    public function test_can_delete_patient()
    {
        $patient = Patient::factory()->create();

        $response = $this->deleteJson("/api/v2/patients/{$patient->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Patient deleted successfully'
            ]);

        $this->assertSoftDeleted('patients', [
            'id' => $patient->id
        ]);
    }

    /**
     * Test retrieving a single patient
     */
    public function test_can_retrieve_patient()
    {
        $patient = Patient::factory()->create();

        $response = $this->getJson("/api/v2/patients/{$patient->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'location_id',
                    'age',
                    'first_name',
                    'last_name',
                    'gender',
                    'birth_date',
                    'address',
                    'city',
                    'state',
                    'zip',
                    'status',
                    'language',
                    'parent_guardian_name',
                    'relationship',
                    'home_phone',
                    'work_phone',
                    'school_name',
                    'school_number',
                ]
            ]);
    }

    /**
     * Test patient validation rules
     */
    public function test_patient_validation_rules()
    {
        $response = $this->postJson('/api/v2/patients', [
            // Sending empty data to trigger validation
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'gender']);
    }

    /**
     * Test listing patients with filters
     */
    public function test_can_list_patients_with_filters()
    {
        // Create test patients
        Patient::factory()->count(2)->create();
        $searchPatient = Patient::factory()->create([
            'first_name' => 'UniqueSearchName',
            'last_name' => 'TestLastName'
        ]);

        // Test basic listing
        $response = $this->getJson('/api/v2/patients');
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
        $searchResponse = $this->getJson('/api/v2/patients?search=UniqueSearchName');
        $searchResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.first_name', 'UniqueSearchName')
            ->assertJsonPath('data.data.0.id', $searchPatient->id);

        // Test with status filter
        $statusResponse = $this->getJson('/api/v2/patients?status=active');
        $statusResponse->assertStatus(200);
    }

    public function test_show_endpoint_returns_correct_patient()
    {
        // Create multiple patients
        $patient1 = Patient::factory()->create(['first_name' => 'Patient One']);
        $patient2 = Patient::factory()->create(['first_name' => 'Patient Two']);
        $patient3 = Patient::factory()->create(['first_name' => 'Patient Three']);

        // Request the second patient specifically
        $response = $this->getJson("/api/v2/patients/{$patient2->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $patient2->id,
                    'first_name' => 'Patient Two'
                ]
            ]);

        // Verify it's not returning the first patient
        $response->assertJsonMissing([
            'data' => [
                'id' => $patient1->id,
                'first_name' => 'Patient One'
            ]
        ]);
    }
}
