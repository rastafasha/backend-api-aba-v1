<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Patient\Patient;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\PaService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
class NoteTimeLimitsTest extends TestCase
{
    use RefreshDatabase;

    protected $patient;
    protected $provider;
    protected $paService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->patient = Patient::factory()->create();
        $this->provider = User::factory()->create();
        $permission = Permission::create(['name' => 'ignore_time_limits']);
        $this->provider->givePermissionTo($permission);

        // Create PaService with enough units for our tests
        $this->paService = PaService::factory()->create([
            'patient_id' => $this->patient->id,
            'n_units' => 1000, // Plenty of units for testing
            'spent_units' => 0,
            'start_date' => now()->subDays(30),
            'end_date' => now()->addDays(30),
        ]);
    }

    /** @test */
    public function it_validates_daily_limit_for_rbt_notes()
    {
        $sessionDate = now()->subDays(2)->format('Y-m-d');

        // Create existing notes that sum up to 9 hours (540 minutes)
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '08:00',
            'time_out' => '14:00', // 6 hours
            'pa_service_id' => $this->paService->id,
        ]);

        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '15:00',
            'time_out' => '18:00', // 3 hours
            'pa_service_id' => $this->paService->id,
        ]);

        // Try to create a new note that would exceed 10 hours
        $response = $this->postJson('/api/v2/notes/rbt', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '19:00',
            'time_out' => '21:00', // 2 more hours
            'pa_service_id' => $this->paService->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in'])
            ->assertJsonFragment([
                'time_in' => ['Oops! It looks like you\'ve reached the maximum allowable hours for the day. Please review your schedule and adjust accordingly.']
            ]);
    }

    /** @test */
    public function it_validates_weekly_limit_for_rbt_notes()
    {
        // Use a fixed date that's a Monday to avoid any confusion with week boundaries
        $monday = Carbon::parse('2024-01-15'); // This is a Monday
        $tuesday = $monday->copy()->addDay();
        $wednesday = $monday->copy()->addDays(2);
        $thursday = $monday->copy()->addDays(3);
        $friday = $monday->copy()->addDays(4);

        // Create notes for Monday - 8 hours
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $monday,
            'time_in' => '08:00',
            'time_out' => '16:00', // 8 hours
            'pa_service_id' => $this->paService->id,
        ]);

        // Create notes for Tuesday - 8 hours
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $tuesday,
            'time_in' => '08:00',
            'time_out' => '16:00', // 8 hours
            'pa_service_id' => $this->paService->id,
        ]);

        // Create notes for Wednesday - 8 hours
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $wednesday,
            'time_in' => '08:00',
            'time_out' => '16:00', // 8 hours
            'pa_service_id' => $this->paService->id,
        ]);

        // Create notes for Thursday - 8 hours
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $thursday,
            'time_in' => '08:00',
            'time_out' => '16:00', // 8 hours
            'pa_service_id' => $this->paService->id,
        ]);

        // Create notes for Friday - 8 hours (total 40 hours now)
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $friday,
            'time_in' => '08:00',
            'time_out' => '16:00', // 8 hours
            'pa_service_id' => $this->paService->id,
        ]);

        // Try to add another 4-hour session that would exceed 40 hours
        $response = $this->postJson('/api/v2/notes/rbt', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $friday->format('Y-m-d'),
            'time_in' => '16:15', // Added buffer time
            'time_out' => '20:15', // 4 more hours (would be 44 hours total)
            'pa_service_id' => $this->paService->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in'])
            ->assertSee('reached the maximum allowable hours for the week');
    }

    /** @test */
    public function it_validates_combined_rbt_and_bcba_daily_limit()
    {
        $sessionDate = '2024-01-15';

        // Create RBT note - 6 hours
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '08:00',
            'time_out' => '14:00',
            'pa_service_id' => $this->paService->id,
        ]);

        // Create BCBA note - 3 hours
        NoteBcba::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '15:00',
            'time_out' => '18:00',
        ]);

        // Try to add another BCBA note that would exceed 10 hours
        $response = $this->postJson('/api/v2/notes/bcba', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '19:00',
            'time_out' => '21:00', // 2 more hours
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in'])
            ->assertJsonFragment([
                'time_in' => ['Oops! It looks like you\'ve reached the maximum allowable hours for the day. Please review your schedule and adjust accordingly.']
            ]);
    }

    /** @test */
    public function it_allows_notes_within_limits()
    {
        $sessionDate = now()->format('Y-m-d');

        // Create first provider
        $provider1 = User::factory()->create();

        // Create RBT note - 4 hours
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $provider1->id,
            'session_date' => $sessionDate,
            'time_in' => '08:00',
            'time_out' => '12:00',
            'time_in2' => null,  // Explicitly set to null
            'time_out2' => null, // Explicitly set to null
            'pa_service_id' => $this->paService->id,
        ]);

        // Create second provider
        $provider2 = User::factory()->create();

        // Try to add another note that stays within limits
        $response = $this->postJson('/api/v2/notes/rbt', [
            'patient_id' => $this->patient->id,
            'provider_id' => $provider2->id,
            'session_date' => $sessionDate,
            'time_in' => '13:00',
            'time_out' => '16:00',
            'time_in2' => null,  // Explicitly set to null
            'time_out2' => null, // Explicitly set to null
            'pa_service_id' => $this->paService->id,
        ]);

        $response->assertStatus(201); // Should be created successfully
    }

    /** @test */
    public function it_validates_combined_morning_and_afternoon_sessions()
    {
        $sessionDate = now()->format('Y-m-d');

        // Create a note with morning and afternoon sessions - 8 hours total
        NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '08:00',
            'time_out' => '12:00',  // 4 hours
            'time_in2' => '13:00',
            'time_out2' => '17:00', // 4 more hours
            'pa_service_id' => $this->paService->id,
        ]);

        // Try to add another note that would exceed 10 hours
        $response = $this->postJson('/api/v2/notes/rbt', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '18:00',
            'time_out' => '21:00', // 3 more hours (would be 11 hours total)
            'pa_service_id' => $this->paService->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in'])
            ->assertJsonFragment([
                'time_in' => ['Oops! It looks like you\'ve reached the maximum allowable hours for the day. Please review your schedule and adjust accordingly.']
            ]);
    }

    /** @test */
    public function it_excludes_current_note_when_updating()
    {
        $sessionDate = now()->subDay()->format('Y-m-d');

        // Create a note - 8 hours
        $note = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '08:00',
            'time_out' => '16:00',
            'pa_service_id' => $this->paService->id,
        ]);

        // Update the same note with different hours - should be allowed
        $response = $this->putJson("/api/v2/notes/rbt/{$note->id}", [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $sessionDate,
            'time_in' => '09:00',
            'time_out' => '18:00', // 9 hours
            'pa_service_id' => $this->paService->id,
        ]);

        $response->assertStatus(200); // Should be updated successfully
    }
}
