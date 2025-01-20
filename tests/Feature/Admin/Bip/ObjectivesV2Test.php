<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\Plan;
use App\Models\Bip\Objective;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObjectivesV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private Plan $plan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->plan = Plan::factory()
            ->for($this->bip)
            ->create([
                'category' => 'maladaptive',
                'status' => 'active'
            ]);
    }

    /** @test */
    public function it_can_list_objectives()
    {
        $objectives = Objective::factory()
            ->count(4)
            ->sequence(
                [
                    'type' => 'STO',
                    'order' => 1
                ],
                [
                    'type' => 'STO',
                    'order' => 2
                ],
                [
                    'type' => 'STO',
                    'order' => 3
                ],
                [
                    'type' => 'LTO',
                    'order' => 999
                ]
            )
            ->for($this->plan)
            ->create();

        $response = $this->getJson('/api/v2/objectives');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'plan_id',
                            'type',
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
    public function it_can_create_an_objective()
    {
        $data = [
            'plan_id' => $this->plan->id,
            'type' => 'STO',
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-03-31',
            'description' => 'Test Objective',
            'target' => 60,
            'order' => 1
        ];

        $response = $this->postJson('/api/v2/objectives', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('objectives', [
            'plan_id' => $this->plan->id,
            'description' => 'Test Objective',
            'order' => 1
        ]);
    }

    /** @test */
    public function it_prevents_multiple_ltos_for_same_plan()
    {
        $existingLto = Objective::factory()
            ->for($this->plan)
            ->create([
                'type' => 'LTO',
                'order' => 999
            ]);

        $data = [
            'plan_id' => $this->plan->id,
            'type' => 'LTO',
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-06-30',
            'description' => 'Second LTO',
            'target' => 80,
            'order' => 999
        ];

        $response = $this->postJson('/api/v2/objectives', $data);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Plan already has a long term objective'
            ]);
    }

    /** @test */
    public function it_automatically_assigns_next_order_when_creating_sto()
    {
        // Create two existing STOs
        Objective::factory()
            ->count(2)
            ->sequence(
                ['order' => 1],
                ['order' => 2]
            )
            ->for($this->plan)
            ->create([
                'type' => 'STO'
            ]);

        $data = [
            'plan_id' => $this->plan->id,
            'type' => 'STO',
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-03-31',
            'description' => 'Test STO',
            'target' => 60
        ];

        $response = $this->postJson('/api/v2/objectives', $data);

        $response->assertStatus(201);
        $this->assertEquals(3, $response->json('data.order'));
    }

    /** @test */
    public function it_can_reorder_objectives()
    {
        $objectives = Objective::factory()
            ->count(3)
            ->sequence(
                ['order' => 1],
                ['order' => 2],
                ['order' => 3]
            )
            ->for($this->plan)
            ->create([
                'type' => 'STO'
            ]);

        $data = [
            'objectives' => [
                ['id' => $objectives[0]->id, 'order' => 3],
                ['id' => $objectives[1]->id, 'order' => 1],
                ['id' => $objectives[2]->id, 'order' => 2]
            ]
        ];

        $response = $this->postJson('/api/v2/objectives/reorder', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('objectives', [
            'id' => $objectives[0]->id,
            'order' => 3
        ]);
        $this->assertDatabaseHas('objectives', [
            'id' => $objectives[1]->id,
            'order' => 1
        ]);
        $this->assertDatabaseHas('objectives', [
            'id' => $objectives[2]->id,
            'order' => 2
        ]);
    }

    /** @test */
    public function it_maintains_order_when_deleting_objective()
    {
        // Create objectives with specific orders
        $objectives = Objective::factory()
            ->count(4)
            ->sequence(
                ['order' => 1],
                ['order' => 2],
                ['order' => 3],
                ['order' => 4]
            )
            ->for($this->plan)
            ->create([
                'type' => 'STO'
            ]);

        // Delete the second objective
        $response = $this->deleteJson("/api/v2/objectives/{$objectives[1]->id}");
        $response->assertStatus(200);

        // Check that remaining objectives have been reordered
        $this->assertDatabaseHas('objectives', [
            'id' => $objectives[0]->id,
            'order' => 1
        ]);
        $this->assertDatabaseHas('objectives', [
            'id' => $objectives[2]->id,
            'order' => 2
        ]);
        $this->assertDatabaseHas('objectives', [
            'id' => $objectives[3]->id,
            'order' => 3
        ]);
    }

    /** @test */
    public function it_validates_dates_when_creating_objective()
    {
        $data = [
            'plan_id' => $this->plan->id,
            'type' => 'STO',
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2023-12-31', // End date before initial date
            'description' => 'Test Objective',
            'target' => 80
        ];

        $response = $this->postJson('/api/v2/objectives', $data);
        $response->assertStatus(422);
    }

    /** @test */
    public function it_validates_status_values()
    {
        $data = [
            'plan_id' => $this->plan->id,
            'type' => 'STO',
            'status' => 'invalid_status',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-06-30',
            'description' => 'Test Objective',
            'target' => 80
        ];

        $response = $this->postJson('/api/v2/objectives', $data);
        $response->assertStatus(422);
    }

    /** @test */
    public function it_validates_target_values_based_on_plan_category()
    {
        // For maladaptive plans, target should be 0-100 (lower is better)
        $data = [
            'plan_id' => $this->plan->id,
            'type' => 'STO',
            'status' => 'in progress',
            'description' => 'Test Objective',
            'target' => 150 // Invalid target for maladaptive
        ];

        $response = $this->postJson('/api/v2/objectives', $data);
        $response->assertStatus(422);

        // Create a replacement plan and test its target validation
        $replacementPlan = Plan::factory()
            ->for($this->bip)
            ->create([
                'category' => 'replacement'
            ]);

        $data['plan_id'] = $replacementPlan->id;
        $data['target'] = -10; // Invalid target for replacement

        $response = $this->postJson('/api/v2/objectives', $data);
        $response->assertStatus(422);
    }

    /** @test */
    public function it_enforces_lto_order_to_be_last()
    {
        $data = [
            'plan_id' => $this->plan->id,
            'type' => 'LTO',
            'status' => 'not started',
            'description' => 'Test LTO',
            'target' => 0,
            'order' => 1 // Trying to set LTO order to something other than 999
        ];

        $response = $this->postJson('/api/v2/objectives', $data);

        $response->assertStatus(201);
        $this->assertEquals(999, $response->json('data.order')); // Should force order to 999
    }
}
