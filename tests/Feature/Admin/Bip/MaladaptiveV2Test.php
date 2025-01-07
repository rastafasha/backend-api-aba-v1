<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\Maladaptive;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaladaptiveV2Test extends TestCase
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
    public function it_can_list_maladaptive_behaviors_with_objectives()
    {
        // Create a maladaptive behavior with both types of objectives
        $maladaptive = Maladaptive::factory()
            ->for($this->bip)
            ->create();

        $lto = LongTermObjective::factory()
            ->forMaladaptive($maladaptive)
            ->create();

        // Create STOs with specific orders
        $stos = [];
        for ($i = 1; $i <= 3; $i++) {
            $stos[] = ShortTermObjective::factory()
                ->forMaladaptive($maladaptive)
                ->withOrder($i)
                ->create();
        }

        $response = $this->getJson('/api/v2/maladaptives');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonPath('data.data.1.long_term_objectives.0.status', $lto->status)
            ->assertJsonPath('data.data.1.short_term_objectives.0.order', 1)
            ->assertJsonPath('data.data.1.short_term_objectives.1.order', 2)
            ->assertJsonPath('data.data.1.short_term_objectives.2.order', 3);
    }

    /** @test */
    public function it_can_filter_maladaptive_behaviors()
    {
        // Create additional maladaptive behaviors with different attributes
        Maladaptive::factory()
            ->count(3)
            ->for($this->bip)
            ->create();

        // Test BIP ID filter
        $response = $this->getJson("/api/v2/maladaptives?bip_id={$this->bip->id}");
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data.data'); // 3 new + 1 from setUp

        // Test name filter
        $specificName = 'Specific Behavior';
        $specificMaladaptive = Maladaptive::factory()
            ->for($this->bip)
            ->create(['name' => $specificName]);

        $response = $this->getJson("/api/v2/maladaptives?name={$specificName}");
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.name', $specificName);

        // Test status filter
        $specificStatus = 'active';
        $specificMaladaptive = Maladaptive::factory()
            ->for($this->bip)
            ->create(['status' => $specificStatus]);

        $response = $this->getJson("/api/v2/maladaptives?status={$specificStatus}");
        $response->assertStatus(200)
            ->assertJsonPath('data.data.0.status', $specificStatus);
    }

    /** @test */
    public function it_can_create_maladaptive_behavior_with_objectives()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'name' => 'Test Behavior',
            'description' => 'Test Description',
            'baseline_level' => 5,
            'baseline_date' => now()->format('Y-m-d H:i:s'),
            'initial_intensity' => 7,
            'current_intensity' => 4,
            'status' => 'active',
            'long_term_objectives' => [
                [
                    'status' => 'not started',
                    'description' => 'Long term goal',
                    'target' => 0
                ]
            ],
            'short_term_objectives' => [
                [
                    'status' => 'not started',
                    'description' => 'First short term goal',
                    'target' => 3
                ],
                [
                    'status' => 'not started',
                    'description' => 'Second short term goal',
                    'target' => 2
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/maladaptives', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Maladaptive behavior created successfully'
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'bip_id',
                    'name',
                    'description',
                    'baseline_level',
                    'baseline_date',
                    'initial_intensity',
                    'current_intensity',
                    'status',
                    'long_term_objectives',
                    'short_term_objectives'
                ]
            ]);

        $this->assertDatabaseHas('maladaptives', [
            'name' => 'Test Behavior',
            'description' => 'Test Description'
        ]);

        $maladaptiveId = $response->json('data.id');
        $this->assertDatabaseHas('long_term_objectives', [
            'maladaptive_id' => $maladaptiveId,
            'status' => 'not started'
        ]);

        $this->assertDatabaseHas('short_term_objectives', [
            'maladaptive_id' => $maladaptiveId,
            'status' => 'not started',
            'order' => 1
        ]);
    }

    /** @test */
    public function it_can_show_a_maladaptive_behavior_with_objectives()
    {
        $lto = LongTermObjective::factory()
            ->forMaladaptive($this->maladaptive)
            ->create();

        $stos = ShortTermObjective::factory()
            ->count(3)
            ->forMaladaptive($this->maladaptive)
            ->create();

        $response = $this->getJson("/api/v2/maladaptives/{$this->maladaptive->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'bip_id',
                    'name',
                    'description',
                    'baseline_level',
                    'baseline_date',
                    'initial_intensity',
                    'current_intensity',
                    'status',
                    // 'bip',
                    'long_term_objectives',
                    'short_term_objectives'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_maladaptive()
    {
        $response = $this->getJson('/api/v2/maladaptives/99999');
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_maladaptive_behavior()
    {
        $data = [
            'name' => 'Updated Behavior',
            'description' => 'Updated Description',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/v2/maladaptives/{$this->maladaptive->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('maladaptives', [
            'id' => $this->maladaptive->id,
            'name' => 'Updated Behavior',
            'description' => 'Updated Description',
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function it_can_delete_a_maladaptive_behavior_and_its_objectives()
    {
        $lto = LongTermObjective::factory()
            ->forMaladaptive($this->maladaptive)
            ->create();

        $stos = ShortTermObjective::factory()
            ->count(3)
            ->forMaladaptive($this->maladaptive)
            ->create();

        $response = $this->deleteJson("/api/v2/maladaptives/{$this->maladaptive->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('maladaptives', ['id' => $this->maladaptive->id]);
        $this->assertDatabaseMissing('long_term_objectives', ['id' => $lto->id]);
        $this->assertDatabaseMissing('short_term_objectives', ['id' => $stos[0]->id]);
    }
}
