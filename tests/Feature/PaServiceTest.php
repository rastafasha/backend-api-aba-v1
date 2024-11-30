<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PaServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $patient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->patient = Patient::factory()->create();
    }

    public function test_can_list_pa_services()
    {
        PaService::factory()->count(3)->create([
            'patient_id' => $this->patient->id
        ]);

        $response = $this->getJson("/api/v2/patients/{$this->patient->id}/pa-services");

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
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total'
                ]
            ]);
    }

    public function test_can_create_pa_service()
    {
        $paServiceData = [
            'pa_service' => 'BCBA Analysis Test',
            'cpt' => '97151',
            'n_units' => 8,
            'start_date' => '2024-03-01',
            'end_date' => '2024-04-01'
        ];

        $response = $this->postJson(
            "/api/v2/patients/{$this->patient->id}/pa-services",
            $paServiceData
        );

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service created successfully'
            ]);

        $this->assertDatabaseHas('pa_services', [
            'patient_id' => $this->patient->id,
            'pa_service' => $paServiceData['pa_service'],
            'cpt' => $paServiceData['cpt']
        ]);
    }

    public function test_can_show_pa_service()
    {
        $paService = PaService::factory()->create([
            'patient_id' => $this->patient->id
        ]);

        $response = $this->getJson(
            "/api/v2/patients/{$this->patient->id}/pa-services/{$paService->id}"
        );

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
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
            ]);
    }

    public function test_can_update_pa_service()
    {
        $paService = PaService::factory()->create([
            'patient_id' => $this->patient->id
        ]);

        $updatedData = [
            'pa_service' => 'Updated Service',
            'cpt' => '97153',
            'n_units' => 12,
            'start_date' => '2024-04-01',
            'end_date' => '2024-05-01'
        ];

        $response = $this->putJson(
            "/api/v2/patients/{$this->patient->id}/pa-services/{$paService->id}",
            $updatedData
        );

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service updated successfully'
            ]);

        $this->assertDatabaseHas('pa_services', [
            'id' => $paService->id,
            'pa_service' => 'Updated Service'
        ]);
    }

    public function test_can_delete_pa_service()
    {
        $paService = PaService::factory()->create([
            'patient_id' => $this->patient->id
        ]);

        $response = $this->deleteJson(
            "/api/v2/patients/{$this->patient->id}/pa-services/{$paService->id}"
        );

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service deleted successfully'
            ]);

        $this->assertSoftDeleted('pa_services', [
            'id' => $paService->id
        ]);
    }

    public function test_returns_404_for_invalpatient_id()
    {
        $response = $this->getJson("/api/v2/patients/invalid-id/pa-services");

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Patient not found'
            ]);
    }

    public function test_validates_required_fields_for_creation()
    {
        $response = $this->postJson(
            "/api/v2/patients/{$this->patient->id}/pa-services",
            []
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'pa_service',
                'cpt',
                'n_units',
                'start_date',
                'end_date'
            ]);
    }
}
