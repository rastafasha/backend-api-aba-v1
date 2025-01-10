<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\Plan;
use App\Models\Bip\Objective;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanV2Test extends TestCase
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
    public function it_can_list_plans_with_objectives()
    {
        // Create a plan with objectives
        $plan = Plan::factory()
            ->for($this->bip)
            ->create([
                'category' => 'replacement',
                'status' => 'active'
            ]);

        // Create LTO (always last in order)
        $lto = Objective::factory()
            ->for($plan)
            ->create([
                'type' => 'LTO',
                'order' => 999
            ]);

        // Create STOs with specific orders
        $stos = [];
        for ($i = 1; $i <= 3; $i++) {
            $stos[] = Objective::factory()
                ->for($plan)
                ->create([
                    'type' => 'STO',
                    'order' => $i
                ]);
        }

        $response = $this->getJson('/api/v2/plans');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonPath('data.data.1.objectives.0.type', 'STO')
            ->assertJsonPath('data.data.1.objectives.0.order', 1)
            ->assertJsonPath('data.data.1.objectives.3.type', 'LTO')
            ->assertJsonPath('data.data.1.objectives.3.order', 999);
    }

    /** @test */
    public function it_can_filter_plans()
    {
        // Create additional plans with different attributes
        Plan::factory()
            ->count(3)
            ->for($this->bip)
            ->create([
                'category' => 'maladaptive',
                'status' => 'completed'
            ]);

        // Test BIP ID filter
        $response = $this->getJson("/api/v2/plans?bip_id={$this->bip->id}");
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data.data'); // 3 new + 1 from setUp

        // Test name filter
        $specificName = 'Specific Plan';
        $specificPlan = Plan::factory()
            ->for($this->bip)
            ->create([
                'name' => $specificName,
                'category' => 'replacement'
            ]);

        $response = $this->getJson("/api/v2/plans?name={$specificName}");
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.name', $specificName);

        // Test category filter
        $response = $this->getJson('/api/v2/plans?category=replacement');
        $response->assertStatus(200)
            ->assertJsonPath('data.data.0.category', 'replacement');

        // Test status filter
        $response = $this->getJson('/api/v2/plans?status=completed');
        $response->assertStatus(200)
            ->assertJsonPath('data.data.0.status', 'completed');
    }

    /** @test */
    public function it_can_create_plan_with_objectives()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'name' => 'Test Plan',
            'description' => 'Test Description',
            'category' => 'maladaptive',
            'baseline_level' => 5,
            'baseline_date' => now()->format('Y-m-d'),
            'initial_intensity' => 7,
            'current_intensity' => 4,
            'status' => 'active',
            'objectives' => [
                [
                    'type' => 'LTO',
                    'status' => 'not started',
                    'description' => 'Long term goal',
                    'target' => 0,
                    'order' => 999
                ],
                [
                    'type' => 'STO',
                    'status' => 'not started',
                    'description' => 'First short term goal',
                    'target' => 3,
                    'order' => 1
                ],
                [
                    'type' => 'STO',
                    'status' => 'not started',
                    'description' => 'Second short term goal',
                    'target' => 2,
                    'order' => 2
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/plans', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Plan created successfully'
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'bip_id',
                    'name',
                    'description',
                    'category',
                    'baseline_level',
                    'baseline_date',
                    'initial_intensity',
                    'current_intensity',
                    'status',
                    'objectives'
                ]
            ]);

        $this->assertDatabaseHas('plans', [
            'name' => 'Test Plan',
            'description' => 'Test Description',
            'category' => 'maladaptive'
        ]);

        $planId = $response->json('data.id');
        $this->assertDatabaseHas('objectives', [
            'plan_id' => $planId,
            'type' => 'LTO',
            'status' => 'not started',
            'order' => 999
        ]);

        $this->assertDatabaseHas('objectives', [
            'plan_id' => $planId,
            'type' => 'STO',
            'status' => 'not started',
            'order' => 1
        ]);
    }

    /** @test */
    public function it_can_show_a_plan_with_objectives()
    {
        // Create objectives for the plan
        $lto = Objective::factory()
            ->for($this->plan)
            ->create([
                'type' => 'LTO',
                'order' => 999
            ]);

        $stos = Objective::factory()
            ->count(3)
            ->for($this->plan)
            ->sequence(
                ['order' => 1],
                ['order' => 2],
                ['order' => 3]
            )
            ->create([
                'type' => 'STO'
            ]);

        $response = $this->getJson("/api/v2/plans/{$this->plan->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'bip_id',
                    'name',
                    'description',
                    'category',
                    'baseline_level',
                    'baseline_date',
                    'initial_intensity',
                    'current_intensity',
                    'status',
                    'objectives'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_plan()
    {
        $response = $this->getJson('/api/v2/plans/99999');
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_plan()
    {
        $data = [
            'name' => 'Updated Plan',
            'description' => 'Updated Description',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/v2/plans/{$this->plan->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Plan updated successfully'
            ])
            ->assertJsonPath('data.name', 'Updated Plan')
            ->assertJsonPath('data.description', 'Updated Description')
            ->assertJsonPath('data.status', 'completed');

        $this->assertDatabaseHas('plans', [
            'id' => $this->plan->id,
            'name' => 'Updated Plan',
            'description' => 'Updated Description',
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function it_can_delete_a_plan_and_its_objectives()
    {
        $lto = Objective::factory()
            ->for($this->plan)
            ->create([
                'type' => 'LTO',
                'order' => 999
            ]);

        $stos = Objective::factory()
            ->count(3)
            ->for($this->plan)
            ->create([
                'type' => 'STO'
            ]);

        $response = $this->deleteJson("/api/v2/plans/{$this->plan->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Plan and related objectives deleted successfully'
            ]);

        $this->assertDatabaseMissing('plans', ['id' => $this->plan->id]);
        $this->assertDatabaseMissing('objectives', ['id' => $lto->id]);
        $this->assertDatabaseMissing('objectives', ['id' => $stos[0]->id]);
    }

    /** @test */
    public function it_validates_category_values()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'name' => 'Test Plan',
            'description' => 'Test Description',
            'category' => 'invalid_category',
            'status' => 'active'
        ];

        $response = $this->postJson('/api/v2/plans', $data);
        $response->assertStatus(422);
    }

    /** @test */
    public function it_validates_required_fields_based_on_category()
    {
        // Test maladaptive/replacement categories require baseline fields
        $data = [
            'bip_id' => $this->bip->id,
            'name' => 'Test Plan',
            'description' => 'Test Description',
            'category' => 'maladaptive',
            'status' => 'active'
            // Missing baseline_level, baseline_date, etc.
        ];

        $response = $this->postJson('/api/v2/plans', $data);
        $response->assertStatus(422);

        // Test caregiver/rbt categories don't require baseline fields
        $data['category'] = 'caregiver_training';
        $response = $this->postJson('/api/v2/plans', $data);
        $response->assertStatus(201);
    }
}
