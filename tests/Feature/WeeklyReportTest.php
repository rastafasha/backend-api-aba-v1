<?php

namespace Tests\Feature;

use App\Models\Bip\Plan;
use App\Models\User;
use App\Models\WeeklyReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeeklyReportTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $plan;
    protected $weeklyReport;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for authentication
        $this->user = User::factory()->create();

        // Create a plan for testing
        $this->plan = Plan::factory()->create();

        // Create a weekly report for testing
        $this->weeklyReport = WeeklyReport::create([
            'plan_id' => $this->plan->id,
            'week_start' => '2024-01-01',
            'week_end' => '2024-01-07',
            'value' => 75
        ]);
    }

    /** @test */
    public function it_can_list_weekly_reports()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/v2/weekly-reports');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'plan_id',
                            'week_start',
                            'week_end',
                            'value',
                            'created_at',
                            'updated_at',
                            'deleted_at'
                        ]
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total'
                ]
            ]);
    }

    /** @test */
    public function it_can_filter_weekly_reports_by_plan_id()
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/v2/weekly-reports?plan_id={$this->plan->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'plan_id' => $this->plan->id
            ]);
    }

    /** @test */
    public function it_can_filter_weekly_reports_by_date_range()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/v2/weekly-reports?date_start=2024-01-01&date_end=2024-01-07');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'week_start' => '2024-01-01',
                'week_end' => '2024-01-07'
            ]);
    }

    /** @test */
    public function it_can_include_plan_relationship()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/v2/weekly-reports?include=plan');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'plan' => [
                                'id',
                                'created_at',
                                'updated_at'
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_weekly_report()
    {
        $data = [
            'plan_id' => $this->plan->id,
            'week_start' => '2024-01-08',
            'week_end' => '2024-01-14',
            'value' => 85
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'plan_id',
                    'week_start',
                    'week_end',
                    'value',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_validates_required_fields_when_creating()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['plan_id', 'week_start', 'week_end', 'value']);
    }

    /** @test */
    public function it_validates_week_end_must_be_after_week_start()
    {
        $data = [
            'plan_id' => $this->plan->id,
            'week_start' => '2024-01-14',
            'week_end' => '2024-01-07', // Before week_start
            'value' => 85
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['week_end']);
    }

    /** @test */
    public function it_can_show_a_weekly_report()
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/v2/weekly-reports/{$this->weeklyReport->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'plan_id',
                    'week_start',
                    'week_end',
                    'value',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            ])
            ->assertJsonFragment([
                'id' => $this->weeklyReport->id,
                'plan_id' => $this->weeklyReport->plan_id,
                'week_start' => $this->weeklyReport->week_start,
                'week_end' => $this->weeklyReport->week_end,
                'value' => $this->weeklyReport->value
            ]);
    }

    /** @test */
    public function it_returns_404_when_showing_non_existent_weekly_report()
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/v2/weekly-reports/99999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Weekly report not found'
            ]);
    }

    /** @test */
    public function it_can_update_a_weekly_report()
    {
        $data = [
            'plan_id' => $this->plan->id,
            'week_start' => '2024-01-15',
            'week_end' => '2024-01-21',
            'value' => 90
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/v2/weekly-reports/{$this->weeklyReport->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'plan_id',
                    'week_start',
                    'week_end',
                    'value',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_partially_update_a_weekly_report()
    {
        $data = [
            'value' => 95
        ];

        $response = $this->actingAs($this->user)
            ->patchJson("/api/v2/weekly-reports/{$this->weeklyReport->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ])
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('weekly_reports', [
            'id' => $this->weeklyReport->id,
            'value' => 95
        ]);
    }

    /** @test */
    public function it_can_delete_a_weekly_report()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v2/weekly-reports/{$this->weeklyReport->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Weekly report deleted successfully'
            ]);

        $this->assertSoftDeleted('weekly_reports', [
            'id' => $this->weeklyReport->id
        ]);
    }

    /** @test */
    public function it_returns_404_when_deleting_non_existent_weekly_report()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson('/api/v2/weekly-reports/99999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Weekly report not found'
            ]);
    }
}
