<?php

namespace Tests\Feature\Admin;

use App\Models\PaService;
use App\Models\Patient\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaServiceV2Test extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $patient;
    protected $paService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();

        // Create a test patient
        $this->patient = Patient::factory()->create();

        // Create a test PA service
        $this->paService = PaService::factory()->create([
            'patient_id' => $this->patient->id,
            'pa_service' => 'Test Service',
            'cpt' => '97151',
            'n_units' => 8,
            'start_date' => '2024-03-01',
            'end_date' => '2024-04-01'
        ]);
    }

    /** @test */
    public function it_can_list_pa_services()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/v2/pa-services');

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
                            'end_date'
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

    /** @test */
    public function it_can_filter_pa_services_by_patient_id()
    {
        // Create another patient and PA service
        $anotherPatient = Patient::factory()->create();
        $anotherPaService = PaService::factory()->create([
            'patient_id' => $anotherPatient->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v2/pa-services?patient_id={$this->patient->id}");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.patient_id', $this->patient->id);
    }

    /** @test */
    public function it_can_create_a_pa_service()
    {
        $paServiceData = [
            'patient_id' => $this->patient->id,
            'pa_service' => 'New Service',
            'cpt' => '97151',
            'n_units' => 10,
            'start_date' => '2024-04-01',
            'end_date' => '2024-05-01'
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/pa-services', $paServiceData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service created successfully'
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'patient_id',
                    'pa_service',
                    'cpt',
                    'n_units',
                    'start_date',
                    'end_date'
                ]
            ]);

        $this->assertDatabaseHas('pa_services', $paServiceData);
    }

    /** @test */
    public function it_can_show_a_pa_service()
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/v2/pa-services/{$this->paService->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $this->paService->id,
                    'patient_id' => $this->patient->id,
                    'pa_service' => 'Test Service',
                    'cpt' => '97151',
                    'n_units' => 8
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_when_showing_non_existent_pa_service()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/v2/pa-services/99999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'PA service not found'
            ]);
    }

    /** @test */
    public function it_can_update_a_pa_service()
    {
        $updatedData = [
            'pa_service' => 'Updated Service',
            'cpt' => '97153',
            'n_units' => 12,
            'start_date' => '2024-05-01',
            'end_date' => '2024-06-01'
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/v2/pa-services/{$this->paService->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service updated successfully'
            ])
            ->assertJsonPath('data.pa_service', 'Updated Service')
            ->assertJsonPath('data.cpt', '97153')
            ->assertJsonPath('data.n_units', 12);

        $this->assertDatabaseHas('pa_services', array_merge(
            ['id' => $this->paService->id],
            $updatedData
        ));
    }

    /** @test */
    public function it_can_delete_a_pa_service()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v2/pa-services/{$this->paService->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'PA service deleted successfully'
            ]);

        // Since we're using soft deletes, the record should still exist but with a deleted_at timestamp
        $this->assertSoftDeleted('pa_services', [
            'id' => $this->paService->id
        ]);
    }

    /** @test */
    public function it_returns_404_when_deleting_non_existent_pa_service()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson('/api/v2/pa-services/99999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'PA service not found'
            ]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/pa-services', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'patient_id',
                'pa_service',
                'cpt',
                'n_units',
                'start_date',
                'end_date'
            ]);
    }

    /** @test */
    public function it_validates_date_range_when_creating()
    {
        $invalidData = [
            'patient_id' => $this->patient->id,
            'pa_service' => 'Test Service',
            'cpt' => '97151',
            'n_units' => 8,
            'start_date' => '2024-04-01',
            'end_date' => '2024-03-01' // End date before start date
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/pa-services', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }
}
