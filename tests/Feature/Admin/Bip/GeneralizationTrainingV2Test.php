<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\GeneralizationTraining;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneralizationTrainingV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private GeneralizationTraining $training;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->training = GeneralizationTraining::factory()->create([
            'bip_id' => $this->bip->id,
            'discharge_plan' => 'Test Discharge Plan',
            'transition_fading_plans' => [
                [
                    'transition_plan' => 'Test Transition Plan 1',
                    'fading_plan' => 'Test Fading Plan 1',
                    'timeline' => '2024-01-01'
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_list_generalization_trainings()
    {
        $response = $this->getJson('/api/v2/generalization-trainings');

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
                            'discharge_plan',
                            'transition_fading_plans'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_filter_trainings_by_bip_id()
    {
        $response = $this->getJson("/api/v2/generalization-trainings?bip_id={$this->bip->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount(1, 'data.data');
    }

    /** @test */
    public function it_can_create_generalization_training()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'discharge_plan' => 'New Discharge Plan',
            'transition_fading_plans' => [
                [
                    'transition_plan' => 'New Transition Plan',
                    'fading_plan' => 'New Fading Plan',
                    'timeline' => '2024-02-01'
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/generalization-trainings', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Generalization training created successfully'
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'bip_id',
                    'discharge_plan',
                    'transition_fading_plans'
                ]
            ]);

        $this->assertDatabaseHas('generalization_trainings', [
            'bip_id' => $this->bip->id,
            'discharge_plan' => 'New Discharge Plan'
        ]);
    }

    /** @test */
    public function it_can_show_generalization_training()
    {
        $response = $this->getJson("/api/v2/generalization-trainings/{$this->training->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'bip_id',
                    'discharge_plan',
                    'transition_fading_plans'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_training()
    {
        $response = $this->getJson('/api/v2/generalization-trainings/99999');
        
        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Generalization training not found'
            ]);
    }

    /** @test */
    public function it_can_update_generalization_training()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'discharge_plan' => 'Updated Discharge Plan',
            'transition_fading_plans' => [
                [
                    'transition_plan' => 'Updated Transition Plan',
                    'fading_plan' => 'Updated Fading Plan',
                    'timeline' => '2024-03-01'
                ]
            ]
        ];

        $response = $this->putJson("/api/v2/generalization-trainings/{$this->training->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Generalization training updated successfully'
            ])
            ->assertJsonPath('data.discharge_plan', 'Updated Discharge Plan');

        $this->assertDatabaseHas('generalization_trainings', [
            'id' => $this->training->id,
            'discharge_plan' => 'Updated Discharge Plan'
        ]);
    }

    /** @test */
    public function it_can_delete_generalization_training()
    {
        $response = $this->deleteJson("/api/v2/generalization-trainings/{$this->training->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Generalization training deleted successfully'
            ]);

        $this->assertSoftDeleted('generalization_trainings', [
            'id' => $this->training->id
        ]);
    }
}