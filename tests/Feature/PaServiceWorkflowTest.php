<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Patient\Patient;
use App\Models\Insurance\Insurance;
use App\Models\Location;
use App\Models\PaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PaServiceWorkflowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $insurance;
    protected $location;

    protected function setUp(): void
    {
        parent::setUp();
        $this->insurance = Insurance::factory()->create();
        $this->location = Location::factory()->create();
    }

    

    public function test_can_create_patient_with_pa_services()
    {
        $startDate = $this->faker->date();
        $endDate = $this->faker->date('Y-m-d', '+1 week'); // Ensure end date is after start date

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
            'pay' => false,
            'pa_services' => [
                [
                    'pa_service' => 'BCBA Analysis Test',
                    'cpt' => '97151',
                    'n_units' => 8,
                    'start_date' => $this->faker->date(),
                    'end_date' => $this->faker->date('Y-m-d', '+1 week')
                ],
                [
                    'pa_service' => 'BCBA Supervision Test',
                    'cpt' => '97155',
                    'n_units' => 4,
                    'start_date' => $startDate,
                     'end_date' => $endDate
                    // 'start_date' => $this->faker->date(),
                    // 'end_date' => $this->faker->date('Y-m-d', '+1 week')
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/patients', $patientData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Patient created successfully'
            ]);

        // Verify both PA services were created
        $this->assertDatabaseHas('pa_services', [
            
            'pa_service' => 'BCBA Analysis Test',
            'cpt' => '97151',
            'n_units' => 8
        ]);

        $this->assertDatabaseHas('pa_services', [
            'pa_service' => 'BCBA Supervision Test',
            'cpt' => '97155',
            'n_units' => 4
        ]);
    }

    public function test_can_add_pa_services_to_existing_patients()
    {
        // Create two test patients
        $patient1 = Patient::factory()->create();
        $patient2 = Patient::factory()->create();

        // Add PA service to first patient
        $paService1Data = [
            'pa_service' => 'BCBA Analysis Test',
            'cpt' => '97151',
            'n_units' => 8,
            'start_date' => '2024-03-01',
            'end_date' => '2024-04-01'
        ];

        $response1 = $this->postJson(
            "/api/v2/patients/{$patient1->id}/pa-services",
            $paService1Data
        );

        $response1->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service created successfully'
            ]);

        // Add different PA service to second patient
        $paService2Data = [
            'pa_service' => 'BCBA Supervision Test',
            'cpt' => '97155',
            'n_units' => 4,
            'start_date' => '2024-03-01',
            'end_date' => '2024-04-01'
        ];

        $response2 = $this->postJson(
            "/api/v2/patients/{$patient2->id}/pa-services",
            $paService2Data
        );

        $response2->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service created successfully'
            ]);

        // Verify services were created for correct patients
        $this->assertDatabaseHas('pa_services', [
            'patient_id' => $patient1->id,
            'pa_service' => 'BCBA Analysis Test',
            'cpt' => '97151'
        ]);

        $this->assertDatabaseHas('pa_services', [
            'patient_id' => $patient2->id,
            'pa_service' => 'BCBA Supervision Test',
            'cpt' => '97155'
        ]);
    }

    public function test_can_retrieve_pa_services_for_patients()
    {
        // Create a patient with multiple PA services
        $patient = Patient::factory()->create();

        PaService::factory()->count(3)->create([
            'patient_id' => $patient->id
        ]);

        // Test retrieving all PA services for the patient
        $response = $this->getJson("/api/v2/patients/{$patient->id}/pa-services");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'patient_id',
                            'pa_service',
                            'cpt',
                            'n_units',
                            'start_date',
                            'end_date',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            ]);

        // Verify the correct number of services is returned
        $this->assertEquals(3, count($response->json('data.data')));

        // Verify all services belong to the correct patient
        foreach ($response->json('data.data') as $service) {
            $this->assertEquals($patient->id, $service['patient_id']);
        }
    }
}
