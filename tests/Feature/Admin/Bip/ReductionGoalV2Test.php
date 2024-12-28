<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\ReductionGoal;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReductionGoalV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private ReductionGoal $goal;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->goal = ReductionGoal::factory()
            ->for($this->bip)
            ->forClient($this->user)
            ->create();
    }

    /** @test */
    public function it_can_list_reduction_goals_with_objectives()
    {
        // Create a goal with both types of objectives
        $goal = ReductionGoal::factory()
            ->for($this->bip)
            ->forClient($this->user)
            ->create();

        $lto = LongTermObjective::factory()
            ->forReductionGoal($goal)
            ->create();

        // Create STOs with specific orders
        $stos = [];
        for ($i = 1; $i <= 3; $i++) {
            $stos[] = ShortTermObjective::factory()
                ->forReductionGoal($goal)
                ->withOrder($i)
                ->create();
        }

        $response = $this->getJson('/api/v2/reduction-goals');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonPath('data.data.1.long_term_objective.status', $lto->status)
            ->assertJsonPath('data.data.1.short_term_objectives.0.order', 1)
            ->assertJsonPath('data.data.1.short_term_objectives.1.order', 2)
            ->assertJsonPath('data.data.1.short_term_objectives.2.order', 3);
    }

    /** @test */
    public function it_can_filter_reduction_goals()
    {
        // Create additional goals with different attributes
        ReductionGoal::factory()
            ->count(3)
            ->for($this->bip)
            ->forClient($this->user)
            ->create();

        $otherBip = Bip::factory()->create();
        $otherGoal = ReductionGoal::factory()
            ->for($otherBip)
            ->forClient($this->user)
            ->create();

        // Test BIP filter
        $response = $this->getJson("/api/v2/reduction-goals?bip_id={$this->bip->id}");
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json('data.data')));

        // Test patient identifier filter
        $response = $this->getJson("/api/v2/reduction-goals?patient_identifier={$this->goal->patient_identifier}");
        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data.data')));

        // Test client filter
        $response = $this->getJson("/api/v2/reduction-goals?client_id={$this->user->id}");
        $response->assertStatus(200);
        $this->assertEquals(5, count($response->json('data.data')));
    }

    /** @test */
    public function it_can_create_a_reduction_goal_with_objectives()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'patient_identifier' => 'PAT123',
            'client_id' => $this->user->id,
            'current_status' => 'active',
            'maladaptive' => 'Inappropriate Language',
            'long_term_objective' => [
                'status' => 'in progress',
                'initial_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'description' => 'Reduce inappropriate language by 80%',
                'target' => 80
            ],
            'short_term_objectives' => [
                [
                    'status' => 'in progress',
                    'initial_date' => '2024-01-01',
                    'end_date' => '2024-03-31',
                    'description' => 'Reduce in classroom',
                    'target' => 60
                ],
                [
                    'status' => 'in progress',
                    'initial_date' => '2024-01-01',
                    'end_date' => '2024-03-31',
                    'description' => 'Reduce in therapy',
                    'target' => 70
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/reduction-goals', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'long_term_objective',
                    'short_term_objectives'
                ]
            ]);

        $this->assertDatabaseHas('reduction_goals', [
            'patient_identifier' => 'PAT123',
            'maladaptive' => 'Inappropriate Language'
        ]);

        $this->assertDatabaseHas('long_term_objectives', [
            'target' => 80,
            'description' => 'Reduce inappropriate language by 80%'
        ]);

        $this->assertDatabaseCount('short_term_objectives', 2);
    }

    /** @test */
    public function it_validates_required_fields_when_creating()
    {
        $response = $this->postJson('/api/v2/reduction-goals', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'bip_id',
                'patient_identifier',
                'client_id',
                'current_status',
                'maladaptive'
            ]);
    }

    /** @test */
    public function it_can_show_a_reduction_goal_with_objectives()
    {
        $lto = LongTermObjective::factory()
            ->forReductionGoal($this->goal)
            ->create();

        $stos = ShortTermObjective::factory()
            ->count(3)
            ->forReductionGoal($this->goal)
            ->create();

        $response = $this->getJson("/api/v2/reduction-goals/{$this->goal->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'bip_id',
                    'patient_identifier',
                    'client_id',
                    'current_status',
                    'maladaptive',
                    'bip',
                    'long_term_objective',
                    'short_term_objectives'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_goal()
    {
        $response = $this->getJson('/api/v2/reduction-goals/99999');
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_reduction_goal()
    {
        $data = [
            'current_status' => 'completed',
            'maladaptive' => 'Updated Behavior'
        ];

        $response = $this->putJson("/api/v2/reduction-goals/{$this->goal->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('reduction_goals', [
            'id' => $this->goal->id,
            'current_status' => 'completed',
            'maladaptive' => 'Updated Behavior'
        ]);
    }

    /** @test */
    public function it_can_delete_a_reduction_goal_and_its_objectives()
    {
        $lto = LongTermObjective::factory()
            ->forReductionGoal($this->goal)
            ->create();

        $stos = ShortTermObjective::factory()
            ->count(3)
            ->forReductionGoal($this->goal)
            ->create();

        $response = $this->deleteJson("/api/v2/reduction-goals/{$this->goal->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('reduction_goals', ['id' => $this->goal->id]);
        $this->assertSoftDeleted('long_term_objectives', ['id' => $lto->id]);
        $this->assertSoftDeleted('short_term_objectives', ['id' => $stos[0]->id]);
    }
}
