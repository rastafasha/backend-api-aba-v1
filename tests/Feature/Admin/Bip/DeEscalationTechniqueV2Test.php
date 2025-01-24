<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\DeEscalationTechnique;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeEscalationTechniqueV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private DeEscalationTechnique $technique;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->technique = DeEscalationTechnique::factory()->create([
            'bip_id' => $this->bip->id,
            'description' => 'Test Description',
            'service_recomendation' => 'Test Recommendation',
            'recomendation_lists' => [
                [
                    'cpt' => '97151',
                    'location' => 'In Home',
                    'num_units' => 32,
                    'breakdown_per_week' => '8',
                    'description_service' => 'Initial Assessment'
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_list_de_escalation_techniques()
    {
        $response = $this->getJson('/api/v2/de-escalation-techniques');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'bip_id',
                            'description',
                            'service_recomendation',
                            'recomendation_lists'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_filter_techniques_by_bip_id()
    {
        $response = $this->getJson("/api/v2/de-escalation-techniques?bip_id={$this->bip->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount(1, 'data.data');
    }

    /** @test */
    public function it_can_create_de_escalation_technique()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'description' => 'New Description',
            'service_recomendation' => 'New Service Recommendation',
            'recomendation_lists' => [
                [
                    'cpt' => '97153',
                    'location' => 'School',
                    'num_units' => 24,
                    'breakdown_per_week' => '6',
                    'description_service' => 'Behavioral Treatment'
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/de-escalation-techniques', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'De-escalation technique created successfully'
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'bip_id',
                    'description',
                    'service_recomendation',
                    'recomendation_lists'
                ]
            ]);

        $this->assertDatabaseHas('de_escalation_techniques', [
            'bip_id' => $this->bip->id,
            'description' => 'New Description'
        ]);
    }

    /** @test */
    public function it_can_show_de_escalation_technique()
    {
        $response = $this->getJson("/api/v2/de-escalation-techniques/{$this->technique->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'bip_id',
                    'description',
                    'service_recomendation',
                    'recomendation_lists'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_technique()
    {
        $response = $this->getJson('/api/v2/de-escalation-techniques/99999');
        
        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'De-escalation technique not found'
            ]);
    }

    /** @test */
    public function it_can_update_de_escalation_technique()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'description' => 'Updated Description',
            'service_recomendation' => 'Updated Service Recommendation',
            'recomendation_lists' => [
                [
                    'cpt' => '97153',
                    'location' => 'Clinic',
                    'num_units' => 16,
                    'breakdown_per_week' => '4',
                    'description_service' => 'Updated Treatment'
                ]
            ]
        ];

        $response = $this->putJson("/api/v2/de-escalation-techniques/{$this->technique->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'De-escalation technique updated successfully'
            ])
            ->assertJsonPath('data.description', 'Updated Description');

        $this->assertDatabaseHas('de_escalation_techniques', [
            'id' => $this->technique->id,
            'description' => 'Updated Description'
        ]);
    }

    /** @test */
    public function it_can_delete_de_escalation_technique()
    {
        $response = $this->deleteJson("/api/v2/de-escalation-techniques/{$this->technique->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'De-escalation technique deleted successfully'
            ]);

        $this->assertSoftDeleted('de_escalation_techniques', [
            'id' => $this->technique->id
        ]);
    }
}