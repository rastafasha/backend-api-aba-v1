<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\Replacement;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplacementV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private Replacement $replacement;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->replacement = Replacement::factory()
            ->for($this->bip)
            ->create();
    }

    /** @test */
    public function it_can_list_replacement_behaviors_with_objectives()
    {
        // Create a replacement behavior with both types of objectives
        $replacement = Replacement::factory()
            ->for($this->bip)
            ->create();

        $lto = LongTermObjective::factory()
            ->forReplacement($replacement)
            ->create();

        // Create STOs with specific orders
        $stos = [];
        for ($i = 1; $i <= 3; $i++) {
            $stos[] = ShortTermObjective::factory()
                ->forReplacement($replacement)
                ->withOrder($i)
                ->create();
        }

        $response = $this->getJson('/api/v2/replacements');

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
    public function it_can_filter_replacement_behaviors()
    {
        // Delete any existing replacements to ensure clean state
        Replacement::query()->delete();

        // Create inactive replacements
        Replacement::factory()
            ->count(3)
            ->for($this->bip)
            ->create(['status' => 'completed']);

        // Create exactly one active replacement
        $activeReplacement = Replacement::factory()
            ->for($this->bip)
            ->create(['status' => 'active']);

        // Test filtering by status
        $response = $this->getJson('/api/v2/replacements?status=active');
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount(1, 'data.data');

        // Test filtering by name
        $namedReplacement = Replacement::factory()
            ->for($this->bip)
            ->create(['name' => 'Specific Behavior']);

        $response = $this->getJson('/api/v2/replacements?name=Specific');
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount(1, 'data.data');

        // Test filtering by BIP ID
        $response = $this->getJson("/api/v2/replacements?bip_id={$this->bip->id}");
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }

    /** @test */
    public function it_can_create_replacement_behavior_with_objectives()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'name' => 'Test Behavior',
            'description' => 'Test Description',
            'baseline_level' => 5,
            'baseline_date' => now()->format('Y-m-d'),
            'initial_intensity' => 7,
            'current_intensity' => 4,
            'status' => 'active',
            'long_term_objectives' => [
                [
                    'status' => 'not started',
                    'description' => 'Long term goal',
                    'target' => 100
                ]
            ],
            'short_term_objectives' => [
                [
                    'status' => 'not started',
                    'description' => 'Short term goal',
                    'target' => 25
                ]
            ]
        ];

        $response = $this->postJson('/api/v2/replacements', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Replacement behavior created successfully'
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

        $this->assertDatabaseHas('replacements', [
            'name' => 'Test Behavior',
            'description' => 'Test Description'
        ]);

        $replacementId = $response->json('data.id');
        $this->assertDatabaseHas('long_term_objectives', [
            'replacement_id' => $replacementId,
            'status' => 'not started'
        ]);

        $this->assertDatabaseHas('short_term_objectives', [
            'replacement_id' => $replacementId,
            'status' => 'not started',
            'order' => 1
        ]);
    }

    /** @test */
    public function it_can_show_a_replacement_behavior_with_objectives()
    {
        $lto = LongTermObjective::factory()
            ->forReplacement($this->replacement)
            ->create();

        $stos = ShortTermObjective::factory()
            ->count(3)
            ->forReplacement($this->replacement)
            ->create();

        $response = $this->getJson("/api/v2/replacements/{$this->replacement->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
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
                    'long_term_objectives',
                    'short_term_objectives'
                ]
            ]);
    }

    /** @test */
    public function it_can_update_a_replacement_behavior()
    {
        $data = [
            'name' => 'Updated Behavior',
            'description' => 'Updated Description',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/v2/replacements/{$this->replacement->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Replacement behavior updated successfully'
            ])
            ->assertJsonPath('data.name', 'Updated Behavior')
            ->assertJsonPath('data.description', 'Updated Description')
            ->assertJsonPath('data.status', 'completed');

        $this->assertDatabaseHas('replacements', [
            'id' => $this->replacement->id,
            'name' => 'Updated Behavior',
            'description' => 'Updated Description',
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function it_can_delete_a_replacement_behavior_and_its_objectives()
    {
        $lto = LongTermObjective::factory()
            ->forReplacement($this->replacement)
            ->create();

        $sto = ShortTermObjective::factory()
            ->forReplacement($this->replacement)
            ->create();

        $response = $this->deleteJson("/api/v2/replacements/{$this->replacement->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Replacement behavior and related objectives deleted successfully'
            ]);

        $this->assertDatabaseMissing('replacements', ['id' => $this->replacement->id]);
        $this->assertDatabaseMissing('long_term_objectives', ['id' => $lto->id]);
        $this->assertDatabaseMissing('short_term_objectives', ['id' => $sto->id]);
    }
}
