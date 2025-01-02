<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\Maladaptive;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObjectivesV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private Maladaptive $maladaptive;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->maladaptive = Maladaptive::factory()
            ->for($this->bip)
            ->create();
    }

    /** @test */
    public function it_can_list_long_term_objectives()
    {
        $ltos = LongTermObjective::factory()
            ->count(3)
            ->forMaladaptive($this->maladaptive)
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
                            'maladaptive_id',
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
            'maladaptive_id' => $this->maladaptive->id,
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
            'maladaptive_id' => $this->maladaptive->id,
            'description' => 'Test LTO'
        ]);
    }

    /** @test */
    public function it_prevents_multiple_ltos_for_same_maladaptive()
    {
        $existingLto = LongTermObjective::factory()
            ->forMaladaptive($this->maladaptive)
            ->create();

        $data = [
            'maladaptive_id' => $this->maladaptive->id,
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
                'message' => 'Maladaptive behavior already has a long term objective'
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
            ->forMaladaptive($this->maladaptive)
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
                            'maladaptive_id',
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
            'maladaptive_id' => $this->maladaptive->id,
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
            'maladaptive_id' => $this->maladaptive->id,
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
            ->forMaladaptive($this->maladaptive)
            ->create();

        $data = [
            'maladaptive_id' => $this->maladaptive->id,
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
            ->forMaladaptive($this->maladaptive)
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
        $stos = ShortTermObjective::factory()
            ->count(4)
            ->sequence(
                ['order' => 1],
                ['order' => 2],
                ['order' => 3],
                ['order' => 4]
            )
            ->forMaladaptive($this->maladaptive)
            ->create();

        // Delete the second STO
        $response = $this->deleteJson("/api/v2/short-term-objectives/{$stos[1]->id}");
        $response->assertStatus(200);

        // Check that remaining STOs have been reordered
        $this->assertDatabaseHas('short_term_objectives', [
            'id' => $stos[0]->id,
            'order' => 1
        ]);
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
            'maladaptive_id' => $this->maladaptive->id,
            'status' => 'in progress',
            'initial_date' => '2024-01-01',
            'end_date' => '2023-12-31', // End date before initial date
            'description' => 'Test Objective',
            'target' => 80
        ];

        $response = $this->postJson('/api/v2/long-term-objectives', $data);
        $response->assertStatus(422);

        $response = $this->postJson('/api/v2/short-term-objectives', $data);
        $response->assertStatus(422);
    }

    /** @test */
    public function it_validates_status_values()
    {
        $data = [
            'maladaptive_id' => $this->maladaptive->id,
            'status' => 'invalid_status',
            'initial_date' => '2024-01-01',
            'end_date' => '2024-06-30',
            'description' => 'Test Objective',
            'target' => 80
        ];

        $response = $this->postJson('/api/v2/long-term-objectives', $data);
        $response->assertStatus(422);

        $response = $this->postJson('/api/v2/short-term-objectives', $data);
        $response->assertStatus(422);
    }
}
