<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Patient\Patient;
use App\Models\PaService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

class NoteBackdatedTest extends TestCase
{
    use RefreshDatabase;

    protected $patient;
    protected $provider;
    protected $paService;
    protected $permission;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->patient = Patient::factory()->create();
        $this->provider = User::factory()->create();
        $this->permission = Permission::create(['name' => 'ignore_time_limits']);

        // Create PaService with enough units for our tests
        $this->paService = PaService::factory()->create([
            'patient_id' => $this->patient->id,
            'n_units' => 1000,
            'spent_units' => 0,
            'start_date' => now()->subDays(30),
            'end_date' => now()->addDays(30),
        ]);
    }

    /** @test */
    public function it_prevents_rbt_notes_older_than_two_weeks()
    {
        $threeWeeksAgo = now()->subWeeks(3)->format('Y-m-d');

        $response = $this->actingAs($this->provider)->postJson('/api/v2/notes/rbt', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $threeWeeksAgo,
            'time_in' => '09:00',
            'time_out' => '10:00',
            'pa_service_id' => $this->paService->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['session_date'])
            ->assertJsonFragment([
                'session_date' => ['Notes cannot be created for sessions more than 2 weeks in the past. Please contact your supervisor if you need to create a note for an older session.']
            ]);
    }

    /** @test */
    public function it_prevents_bcba_notes_older_than_two_weeks()
    {
        $threeWeeksAgo = now()->subWeeks(3)->format('Y-m-d');

        $response = $this->actingAs($this->provider)->postJson('/api/v2/notes/bcba', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $threeWeeksAgo,
            'time_in' => '09:00',
            'time_out' => '10:00',
            'pa_service_id' => $this->paService->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['session_date'])
            ->assertJsonFragment([
                'session_date' => ['Notes cannot be created for sessions more than 2 weeks in the past. Please contact your supervisor if you need to create a note for an older session.']
            ]);
    }

    /** @test */
    public function it_allows_notes_within_two_weeks()
    {
        $oneWeekAgo = now()->subWeek()->format('Y-m-d');

        // Test RBT note
        $rbtResponse = $this->actingAs($this->provider)->postJson('/api/v2/notes/rbt', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $oneWeekAgo,
            'time_in' => '09:00',
            'time_out' => '10:00',
            'pa_service_id' => $this->paService->id,
        ]);

        $rbtResponse->assertStatus(201);

        // Test BCBA note
        $bcbaResponse = $this->actingAs($this->provider)->postJson('/api/v2/notes/bcba', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $oneWeekAgo,
            'time_in' => '11:00',
            'time_out' => '12:00',
            'pa_service_id' => $this->paService->id,
        ]);

        $bcbaResponse->assertStatus(201);
    }

    /** @test */
    public function it_allows_old_notes_with_permission()
    {
        $threeWeeksAgo = now()->subWeeks(3)->format('Y-m-d');

        // Give the provider the permission to ignore time limits
        $this->provider->givePermissionTo($this->permission);

        // Test RBT note
        $rbtResponse = $this->actingAs($this->provider)->postJson('/api/v2/notes/rbt', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $threeWeeksAgo,
            'time_in' => '09:00',
            'time_out' => '10:00',
            'pa_service_id' => $this->paService->id,
        ]);

        $rbtResponse->assertStatus(201);

        // Test BCBA note
        $bcbaResponse = $this->actingAs($this->provider)->postJson('/api/v2/notes/bcba', [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'session_date' => $threeWeeksAgo,
            'time_in' => '11:00',
            'time_out' => '12:00',
            'pa_service_id' => $this->paService->id,
        ]);

        $bcbaResponse->assertStatus(201);
    }
}
