<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\CrisisPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrisisPlanV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private CrisisPlan $crisisPlan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->crisisPlan = CrisisPlan::factory()->create([
            'bip_id' => $this->bip->id,
            'crisis_description' => 'Test Crisis Description',
            'crisis_note' => 'Test Crisis Note',
            'caregiver_requirements_for_prevention_of_crisis' => 'Test Requirements',
            'risk_factors' => [
                'do_not_apply' => false,
                'elopement' => true,
                'assaultive_behavior' => false,
                'aggression' => true,
                'self_injurious_behavior' => false,
                'sexually_offending_behavior' => false,
                'fire_setting' => false,
                'current_substance_abuse' => false,
                'impulsive_behavior' => true,
                'psychotic_symptoms' => false,
                'self_mutilation_cutting' => false,
                'caring_for_ill_family_recipient' => false,
                'current_family_violence' => false,
                'dealing_with_significant' => false,
                'prior_psychiatric_inpatient_admission' => false,
                'other' => ''
            ],
            'suicidalities' => [
                'not_present' => true,
                'ideation' => false,
                'plan' => false,
                'means' => false,
                'prior_attempt' => false
            ],
            'homicidalities' => [
                'not_present' => true,
                'ideation' => false,
                'plan' => false,
                'means' => false,
                'prior_attempt' => false
            ]
        ]);
    }

    /** @test */
    public function it_can_list_crisis_plans()
    {
        $response = $this->getJson('/api/v2/crisis-plans');

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
                            'crisis_description',
                            'crisis_note',
                            'caregiver_requirements_for_prevention_of_crisis',
                            'risk_factors',
                            'suicidalities',
                            'homicidalities'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_filter_crisis_plans_by_bip_id()
    {
        $response = $this->getJson("/api/v2/crisis-plans?bip_id={$this->bip->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount(1, 'data.data');
    }

    /** @test */
    public function it_can_create_crisis_plan()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'crisis_description' => 'New Crisis Description',
            'crisis_note' => 'New Crisis Note',
            'caregiver_requirements_for_prevention_of_crisis' => 'New Requirements',
            'risk_factors' => [
                'do_not_apply' => false,
                'elopement' => false,
                'assaultive_behavior' => true,
                'aggression' => true,
                'self_injurious_behavior' => false,
                'sexually_offending_behavior' => false,
                'fire_setting' => false,
                'current_substance_abuse' => false,
                'impulsive_behavior' => false,
                'psychotic_symptoms' => false,
                'self_mutilation_cutting' => false,
                'caring_for_ill_family_recipient' => false,
                'current_family_violence' => false,
                'dealing_with_significant' => false,
                'prior_psychiatric_inpatient_admission' => false,
                'other' => ''
            ],
            'suicidalities' => [
                'not_present' => false,
                'ideation' => true,
                'plan' => false,
                'means' => false,
                'prior_attempt' => false
            ],
            'homicidalities' => [
                'not_present' => true,
                'ideation' => false,
                'plan' => false,
                'means' => false,
                'prior_attempt' => false
            ]
        ];

        $response = $this->postJson('/api/v2/crisis-plans', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Crisis plan created successfully'
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'bip_id',
                    'crisis_description',
                    'crisis_note',
                    'caregiver_requirements_for_prevention_of_crisis',
                    'risk_factors',
                    'suicidalities',
                    'homicidalities'
                ]
            ]);

        $this->assertDatabaseHas('crisis_plans', [
            'bip_id' => $this->bip->id,
            'crisis_description' => 'New Crisis Description'
        ]);
    }

    /** @test */
    public function it_can_show_crisis_plan()
    {
        $response = $this->getJson("/api/v2/crisis-plans/{$this->crisisPlan->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'bip_id',
                    'crisis_description',
                    'crisis_note',
                    'caregiver_requirements_for_prevention_of_crisis',
                    'risk_factors',
                    'suicidalities',
                    'homicidalities'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_crisis_plan()
    {
        $response = $this->getJson('/api/v2/crisis-plans/99999');
        
        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Crisis plan not found'
            ]);
    }

    /** @test */
    public function it_can_update_crisis_plan()
    {
        $data = [
            'bip_id' => $this->bip->id,  // Add the required bip_id
            'crisis_description' => 'Updated Crisis Description',
            'crisis_note' => 'Updated Crisis Note',
            'risk_factors' => [
                'do_not_apply' => false,
                'elopement' => true,
                'assaultive_behavior' => true,
                'aggression' => false,
                'self_injurious_behavior' => false,
                'sexually_offending_behavior' => false,
                'fire_setting' => false,
                'current_substance_abuse' => false,
                'impulsive_behavior' => false,
                'psychotic_symptoms' => false,
                'self_mutilation_cutting' => false,
                'caring_for_ill_family_recipient' => false,
                'current_family_violence' => false,
                'dealing_with_significant' => false,
                'prior_psychiatric_inpatient_admission' => false,
                'other' => ''
            ]
        ];

        $response = $this->putJson("/api/v2/crisis-plans/{$this->crisisPlan->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Crisis plan updated successfully'
            ])
            ->assertJsonPath('data.crisis_description', 'Updated Crisis Description');

        $this->assertDatabaseHas('crisis_plans', [
            'id' => $this->crisisPlan->id,
            'crisis_description' => 'Updated Crisis Description'
        ]);
    }

    /** @test */
    public function it_can_delete_crisis_plan()
    {
        $response = $this->deleteJson("/api/v2/crisis-plans/{$this->crisisPlan->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Crisis plan deleted successfully'
            ]);

        $this->assertSoftDeleted('crisis_plans', [
            'id' => $this->crisisPlan->id
        ]);
    }
}