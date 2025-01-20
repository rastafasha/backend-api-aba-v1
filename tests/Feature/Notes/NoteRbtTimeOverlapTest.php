<?php

namespace Tests\Feature\Notes;

use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Models\User;
use App\Models\PaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;
class NoteRbtTimeOverlapTest extends TestCase
{
    use RefreshDatabase;

    private $patient;
    private $provider;
    private $doctor;
    private $paService;
    private $baseData;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->patient = Patient::factory()->create();
        $this->provider = User::factory()->create();
        $permission = Permission::create(['name' => 'ignore_time_limits']);
        $this->provider->givePermissionTo($permission);
        $this->doctor = User::factory()->create();
        $this->paService = PaService::factory()->create();

        $this->baseData = [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'doctor_id' => $this->doctor->id,
            'pa_service_id' => $this->paService->id,
            'session_date' => '2024-01-15',
            'billed' => false,
            'paid' => false,
        ];
    }

    /** @test */
    public function it_allows_non_overlapping_morning_sessions()
    {
        // Create first note
        NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        // Try to create second note with non-overlapping time
        $response = $this->actingAs($this->provider)->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in' => '10:30',
            'time_out' => '11:30',
        ]));

        $response->assertStatus(201);
    }

    /** @test */
    public function it_prevents_overlapping_morning_sessions()
    {
        // Create first note
        NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        // Try to create second note with overlapping time
        $response = $this->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in' => '09:30',
            'time_out' => '10:30',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }

    /** @test */
    public function it_allows_non_overlapping_afternoon_sessions()
    {
        // Create first note
        NoteRbt::create(array_merge($this->baseData, [
            'time_in2' => '14:00',
            'time_out2' => '15:00',
        ]));

        // Try to create second note with non-overlapping time
        $response = $this->actingAs($this->provider)->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in2' => '15:30',
            'time_out2' => '16:30',
        ]));

        $response->assertStatus(201);
    }

    /** @test */
    public function it_prevents_overlapping_afternoon_sessions()
    {
        // Create first note
        NoteRbt::create(array_merge($this->baseData, [
            'time_in2' => '14:00',
            'time_out2' => '15:00',
        ]));

        // Try to create second note with overlapping time
        $response = $this->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in2' => '14:30',
            'time_out2' => '15:30',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }

    /** @test */
    public function it_prevents_cross_session_overlaps()
    {
        // Create first note with morning session
        NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        // Try to create second note with afternoon session overlapping first note's morning session
        $response = $this->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in2' => '09:30',
            'time_out2' => '10:30',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }

    /** @test */
    public function it_prevents_provider_having_overlapping_sessions_with_different_patients()
    {
        // Create first note
        NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        $anotherPatient = Patient::factory()->create();

        // Try to create second note for different patient but same provider and overlapping time
        $response = $this->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'patient_id' => $anotherPatient->id,
            'time_in' => '09:30',
            'time_out' => '10:30',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }

    /** @test */
    public function it_prevents_overlapping_with_bcba_notes()
    {
        // Create BCBA note
        NoteBcba::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        // Try to create RBT note with overlapping time
        $response = $this->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in' => '09:30',
            'time_out' => '10:30',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }

    /** @test */
    public function it_allows_updating_note_with_same_times()
    {
        // Create note
        $note = NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        // Try to update the same note with the same times
        $response = $this->actingAs($this->provider)->putJson("/api/v2/notes/rbt/{$note->id}", array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_prevents_overlapping_when_updating_times()
    {
        // Create first note
        NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        // Create second note
        $note2 = NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '10:30',
            'time_out' => '11:30',
        ]));

        // Try to update second note with times that overlap with first note
        $response = $this->putJson("/api/v2/notes/rbt/{$note2->id}", array_merge($this->baseData, [
            'time_in' => '09:30',
            'time_out' => '10:30',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }

    /** @test */
    public function it_prevents_sessions_without_buffer_time_morning()
    {
        // Create first note
        NoteRbt::create(array_merge($this->baseData, [
            'time_in' => '09:00',
            'time_out' => '10:00',
        ]));

        // Try to create second note with insufficient buffer time (less than 15 minutes)
        $response = $this->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in' => '10:10',
            'time_out' => '11:10',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }

    /** @test */
    public function it_prevents_sessions_without_buffer_time_afternoon()
    {
        // Create first note with afternoon session
        NoteRbt::create(array_merge($this->baseData, [
            'time_in2' => '14:00',
            'time_out2' => '15:00',
        ]));

        // Try to create second note with insufficient buffer time (less than 15 minutes)
        $response = $this->postJson('/api/v2/notes/rbt', array_merge($this->baseData, [
            'time_in2' => '15:05',
            'time_out2' => '16:05',
        ]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_in']);
    }
}
