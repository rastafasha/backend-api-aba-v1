<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\ReductionGoal;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObjectivesV2Test extends TestCase
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
    public function it_can_list_long_term_objectives()
    {
        $ltos = LongTermObjective::factory()
            ->count(3)
            ->forReductionGoal($this->goal)
            ->create();

        $response = $this->getJson('/api/v2/long-term-objectives');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'reduction_goal_id',
                            'status',
                            'initial_date',
                            'end_date',
                            'description',
                            'target'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_long_term_objective()
    {
        $data = [
            'reduction_goal_id' => $this->goal->id,
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-06-30',
            'description' => 'Test LTO',
            'target' => 80
        ];

        $response = $this->postJson('/api/v2/long-term-objectives', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('long_term_objectives', [
            'reduction_goal_id' => $this->goal->id,
            'description' => 'Test LTO'
        ]);
    }

    /** @test */
    public function it_prevents_multiple_ltos_for_same_goal()
    {
        $existingLto = LongTermObjective::factory()
            ->forReductionGoal($this->goal)
            ->create();

        $data = [
            'reduction_goal_id' => $this->goal->id,
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-06-30',
            'description' => 'Second LTO',
            'target' => 80
        ];

        $response = $this->postJson('/api/v2/long-term-objectives', $data);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Reduction goal already has a long term objective'
            ]);
    }

    /** @test */
    public function it_can_list_short_term_objectives()
    {
        $stos = ShortTermObjective::factory()
            ->count(3)
            ->sequence(
                ['order' => 1],
                ['order' => 2],
                ['order' => 3]
            )
            ->forReductionGoal($this->goal)
            ->create();

        $response = $this->getJson('/api/v2/short-term-objectives');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'reduction_goal_id',
                            'status',
                            'initial_date',
                            'end_date',
                            'description',
                            'target',
                            'order'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_short_term_objective()
    {
        $data = [
            'reduction_goal_id' => $this->goal->id,
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-03-31',
            'description' => 'Test STO',
            'target' => 60,
            'order' => 1
        ];

        $response = $this->postJson('/api/v2/short-term-objectives', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('short_term_objectives', [
            'reduction_goal_id' => $this->goal->id,
            'description' => 'Test STO',
            'order' => 1
        ]);
    }

    /** @test */
    public function it_automatically_assigns_next_order_when_creating_sto()
    {
        // Create two existing STOs
        ShortTermObjective::factory()
            ->count(2)
            ->sequence(
                ['order' => 1],
                ['order' => 2]
            )
            ->forReductionGoal($this->goal)
            ->create();

        $data = [
            'reduction_goal_id' => $this->goal->id,
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-03-31',
            'description' => 'Test STO',
            'target' => 60
        ];

        $response = $this->postJson('/api/v2/short-term-objectives', $data);

        $response->assertStatus(201);
        $this->assertEquals(3, $response->json('data.order'));
    }

    /** @test */
    public function it_can_reorder_short_term_objectives()
    {
        $stos = ShortTermObjective::factory()
            ->count(3)
            ->sequence(
                ['order' => 1],
                ['order' => 2],
                ['order' => 3]
            )
            ->forReductionGoal($this->goal)
            ->create();

        $data = [
            'objectives' => [
                ['id' => $stos[0]->id, 'order' => 3],
                ['id' => $stos[1]->id, 'order' => 1],
                ['id' => $stos[2]->id, 'order' => 2]
            ]
        ];

        $response = $this->postJson('/api/v2/short-term-objectives/reorder', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('short_term_objectives', [
            'id' => $stos[0]->id,
            'order' => 3
        ]);
        $this->assertDatabaseHas('short_term_objectives', [
            'id' => $stos[1]->id,
            'order' => 1
        ]);
        $this->assertDatabaseHas('short_term_objectives', [
            'id' => $stos[2]->id,
            'order' => 2
        ]);
    }

    /** @test */
    public function it_maintains_order_when_deleting_sto()
    {
        // Create STOs with specific orders
        $stos = [];
        for ($i = 1; $i <= 4; $i++) {
            $stos[] = ShortTermObjective::factory()
                ->forReductionGoal($this->goal)
                ->withOrder($i)
                ->create();
        }

        // Delete the second STO
        $response = $this->deleteJson("/api/v2/short-term-objectives/{$stos[1]->id}");

        $response->assertStatus(200);

        // Check that subsequent STOs were reordered
        $this->assertDatabaseHas('short_term_objectives', [
            'id' => $stos[2]->id,
            'order' => 2
        ]);
        $this->assertDatabaseHas('short_term_objectives', [
            'id' => $stos[3]->id,
            'order' => 3
        ]);
    }

    /** @test */
    public function it_validates_dates_when_creating_objectives()
    {
        $data = [
            'reduction_goal_id' => $this->goal->id,
            'status' => 'in progress',
            'initial_date' => '2024-06-01', // Later than end_date
            'end_date' => '2024-01-01',
            'description' => 'Test Objective',
            'target' => 80
        ];

        // Test LTO validation
        $response = $this->postJson('/api/v2/long-term-objectives', $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);

        // Test STO validation
        $response = $this->postJson('/api/v2/short-term-objectives', $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    /** @test */
    public function it_validates_status_values()
    {
        $data = [
            'reduction_goal_id' => $this->goal->id,
            'status' => 'invalid_status',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-06-30',
            'description' => 'Test Objective',
            'target' => 80
        ];

        // Test LTO validation
        $response = $this->postJson('/api/v2/long-term-objectives', $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);

        // Test STO validation
        $response = $this->postJson('/api/v2/short-term-objectives', $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }
}
