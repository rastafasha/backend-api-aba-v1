<?php

namespace Tests\Feature;

use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Models\User;
use App\Models\WeeklyReport;
use App\Models\Bip\Plan;
use App\Models\Bip\Bip;
use App\Models\PaService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeeklyReportGeneratorV2Test extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $patient;
    protected $bip;
    protected $maladaptivePlan;
    protected $replacementPlan;
    protected $paService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user
        $this->user = User::factory()->create();

        // Create test patient
        $this->patient = Patient::factory()->create();

        // Create PA Service for the patient
        $this->paService = PaService::factory()->create([
            'patient_id' => $this->patient->id,
            'n_units' => 1000, // High number to avoid unit limits
            'spent_units' => 0
        ]);

        // Create BIP for the patient
        $this->bip = Bip::factory()->create([
            'client_id' => $this->patient->id
        ]);

        // Create test plans
        $this->maladaptivePlan = Plan::factory()->create([
            'category' => 'maladaptive',
            'bip_id' => $this->bip->id,
            'baseline_level' => 10,
            'baseline_date' => now()->subWeek(),
            'initial_intensity' => 5,
            'current_intensity' => 3,
            'status' => 'active'
        ]);

        $this->replacementPlan = Plan::factory()->create([
            'category' => 'replacement',
            'bip_id' => $this->bip->id,
            'baseline_level' => 20,
            'baseline_date' => now()->subWeek(),
            'initial_intensity' => 2,
            'current_intensity' => 4,
            'status' => 'active'
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['patient_id', 'start_date', 'end_date']);
    }

    /** @test */
    public function it_validates_date_range()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', [
                'patient_id' => $this->patient->id,
                'start_date' => '2024-01-01',
                'end_date' => '2023-12-31' // End date before start date
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    /** @test */
    public function it_validates_maximum_date_range()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', [
                'patient_id' => $this->patient->id,
                'start_date' => '2024-01-01',
                'end_date' => '2025-01-02' // More than 1 year
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Date range cannot exceed 1 year'
            ]);
    }

    /** @test */
    public function it_generates_reports_for_maladaptive_plans()
    {
        // Create RBT notes for two consecutive weeks
        $weekOneStart = Carbon::parse('2024-01-07'); // Sunday
        $weekTwoStart = $weekOneStart->copy()->addWeek();

        // Week 1 notes
        $note1 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'session_date' => $weekOneStart,
            'pa_service_id' => $this->paService->id,
            'bip_id' => $this->bip->id,
            'maladaptives' => json_encode([
                [
                    'id' => $this->maladaptivePlan->id,
                    'name' => 'Test Maladaptive',
                    'ocurrences' => 5
                ]
            ]),
            'replacements' => json_encode([]),
            'interventions' => json_encode(['positive_reinforcement'])
        ]);

        $note2 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'session_date' => $weekOneStart->copy()->addDays(2),
            'pa_service_id' => $this->paService->id,
            'bip_id' => $this->bip->id,
            'maladaptives' => json_encode([
                [
                    'id' => $this->maladaptivePlan->id,
                    'name' => 'Test Maladaptive',
                    'ocurrences' => 3
                ]
            ]),
            'replacements' => json_encode([]),
            'interventions' => json_encode(['positive_reinforcement'])
        ]);

        // Week 2 notes - should update existing report
        $note3 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'session_date' => $weekOneStart,
            'pa_service_id' => $this->paService->id,
            'bip_id' => $this->bip->id,
            'maladaptives' => json_encode([
                [
                    'id' => $this->maladaptivePlan->id,
                    'name' => 'Test Maladaptive',
                    'ocurrences' => 2
                ]
            ])
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', [
                'patient_id' => $this->patient->id,
                'start_date' => $weekOneStart->format('Y-m-d'),
                'end_date' => $weekTwoStart->format('Y-m-d')
            ]);

        $response->assertStatus(200);

        // Check that only one report was created for week 1
        $this->assertDatabaseCount('weekly_reports', 1);

        // Verify the report values
        $this->assertDatabaseHas('weekly_reports', [
            'plan_id' => $this->maladaptivePlan->id,
            'week_start' => $weekOneStart->format('Y-m-d'),
            'value' => round((5 + 3 + 2) / 3, 2) // Average of all occurrences
        ]);
    }

    /** @test */
    public function it_generates_reports_for_replacement_plans()
    {
        $weekStart = Carbon::parse('2024-01-07'); // Sunday

        // Create RBT notes with replacement plan data
        $note = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'session_date' => $weekStart,
            'pa_service_id' => $this->paService->id,
            'bip_id' => $this->bip->id,
            'replacements' => json_encode([
                [
                    'id' => $this->replacementPlan->id,
                    'name' => 'Test Replacement',
                    'total_trials' => 10,
                    'correct_responses' => 8
                ]
            ]),
            'interventions' => json_encode(['positive_reinforcement'])
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', [
                'patient_id' => $this->patient->id,
                'start_date' => $weekStart->format('Y-m-d'),
                'end_date' => $weekStart->copy()->addDays(6)->format('Y-m-d')
            ]);

        $response->assertStatus(200);

        // Calculate expected percentage
        $totalTrials = 10; // Only one note in this test
        $totalCorrect = 8;
        $expectedPercentage = round(($totalCorrect / $totalTrials) * 100, 2);

        // Verify the report values
        $this->assertDatabaseHas('weekly_reports', [
            'plan_id' => $this->replacementPlan->id,
            'week_start' => $weekStart->format('Y-m-d'),
            'value' => $expectedPercentage
        ]);
    }

    /** @test */
    public function it_updates_existing_reports_instead_of_creating_duplicates()
    {
        $weekStart = Carbon::parse('2024-01-07'); // Sunday

        // Create an existing report
        $existingReport = WeeklyReport::create([
            'plan_id' => $this->maladaptivePlan->id,
            'week_start' => $weekStart->format('Y-m-d'),
            'week_end' => $weekStart->copy()->endOfWeek()->format('Y-m-d'),
            'value' => 10
        ]);

        // Create new RBT note that should update the existing report
        $note = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'session_date' => $weekStart,
            'pa_service_id' => $this->paService->id,
            'bip_id' => $this->bip->id,
            'maladaptives' => json_encode([
                [
                    'id' => $this->maladaptivePlan->id,
                    'name' => 'Test Maladaptive',
                    'ocurrences' => 5
                ]
            ]),
            'replacements' => json_encode([]),
            'interventions' => json_encode(['positive_reinforcement'])
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', [
                'patient_id' => $this->patient->id,
                'start_date' => $weekStart->format('Y-m-d'),
                'end_date' => $weekStart->copy()->addDays(6)->format('Y-m-d')
            ]);

        $response->assertStatus(200);

        // Verify only one report exists and it was updated
        $this->assertDatabaseCount('weekly_reports', 1);
        $this->assertDatabaseHas('weekly_reports', [
            'plan_id' => $this->maladaptivePlan->id,
            'week_start' => $weekStart->format('Y-m-d'),
            'value' => 5 // New value
        ]);
    }

    /** @test */
    public function it_handles_empty_weeks_gracefully()
    {
        $weekStart = Carbon::parse('2024-01-07'); // Sunday

        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', [
                'patient_id' => $this->patient->id,
                'start_date' => $weekStart->format('Y-m-d'),
                'end_date' => $weekStart->copy()->addDays(6)->format('Y-m-d')
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Weekly reports generated successfully',
                'data' => [
                    'patient_id' => $this->patient->id,
                    'reports' => []
                ]
            ]);

        $this->assertDatabaseCount('weekly_reports', 0);
    }

    /** @test */
    public function it_handles_invalid_patient_id()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v2/weekly-reports/generate', [
                'patient_id' => 99999,
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-07'
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['patient_id']);
    }
}
