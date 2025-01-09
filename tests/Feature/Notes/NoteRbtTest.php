<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Location;
use App\Models\Insurance\Insurance;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Models\PaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;

class NoteRbtTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $patient;
    protected $provider;
    protected $supervisor;
    protected $doctor;
    protected $location;
    protected $insurance;
    protected $paService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create necessary related models
        $this->patient = Patient::factory()->create();
        $this->paService = PaService::factory()->create([
            'patient_id' => $this->patient->id,
            'n_units' => 100,
            'spent_units' => 0,
        ]);
        $this->provider = User::factory()->create();
        $this->supervisor = User::factory()->create();
        $this->doctor = User::factory()->create();
        $this->location = Location::factory()->create();
        $this->insurance = Insurance::factory()->create();

        // Create and assign the ignore_time_limits permission
        $permission = Permission::create(['name' => 'ignore_time_limits']);
        $this->provider->givePermissionTo($permission);
    }

    public function test_can_create_note_rbt()
    {
        $sessionDate = now()->subDay();
        $nextSessionDate = $sessionDate->copy()->addDays(7);

        $noteData = [
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'supervisor_id' => $this->supervisor->id,
            'doctor_id' => $this->doctor->id,
            'location_id' => $this->location->id,
            'insurance_id' => $this->insurance->id,
            'session_date' => $sessionDate->format('Y-m-d'),
            'time_in' => '09:00',
            'time_out' => '10:00',
            'time_in2' => '14:00',
            'time_out2' => '15:00',
            'session_length_total' => 120,
            'environmental_changes' => $this->faker->sentence,
            'maladaptives' => ['tantrums' => 3, 'aggression' => 1],
            'replacements' => ['verbal_requests' => 5, 'waiting_quietly' => 4],
            'interventions' => ['positive_reinforcement' => true, 'prompting' => true],
            'meet_with_client_at' => 'Home',
            'client_appeared' => $this->faker->sentence,
            'as_evidenced_by' => $this->faker->sentence,
            'rbt_modeled_and_demonstrated_to_caregiver' => $this->faker->sentence,
            'client_response_to_treatment_this_session' => $this->faker->paragraph,
            'progress_noted_this_session_compared_to_previous_session' => $this->faker->sentence,
            'next_session_is_scheduled_for' => $nextSessionDate->format('Y-m-d'),
            'provider_signature' => $this->faker->name,
            'provider_credential' => 'RBT',
            'status' => 'pending',
            'cpt_code' => '97153',
            'billed' => false,
            'paid' => false,
            'pa_service_id' => $this->paService->id,
        ];

        $response = $this->actingAs($this->provider)->postJson('/api/v2/notes/rbt', $noteData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Note created successfully'
            ]);

        $this->assertDatabaseHas('note_rbts', [
            'patient_id' => $noteData['patient_id'],
            'provider_id' => $noteData['provider_id'],
            'session_date' => $noteData['session_date']
        ]);
    }

    // Cannot create note with time_in after now
    public function test_cannot_create_note_rbt_with_time_in_after_now()
    {
        $noteData = [
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'supervisor_id' => $this->supervisor->id,
            'doctor_id' => $this->doctor->id,
            'location_id' => $this->location->id,
            'insurance_id' => $this->insurance->id,
            'session_date' => now()->addDay()->format('Y-m-d'),
            'pa_service_id' => $this->paService->id,
            'cpt_code' => '97153',
            'next_session_is_scheduled_for' => now()->addDays(7)->format('Y-m-d H:i:s')
        ];

        $response = $this->actingAs($this->provider)->postJson('/api/v2/notes/rbt', $noteData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['session_date'])
            ->assertJson([
                'errors' => [
                    'session_date' => ['Oops! It looks like you’re trying to save a session note with a future date. Please ensure the date and time are accurate before saving.']
                ]
            ]);
    }

    public function test_can_update_note_rbt()
    {
        $note = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'pa_service_id' => $this->paService->id,
        ]);

        $updatedData = [
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'session_date' => $this->faker->date(),
            'doctor_id' => $this->doctor->id,
            'supervisor_id' => $this->supervisor->id,
            'provider_id' => $this->provider->id,
            'client_response_to_treatment_this_session' => 'Updated response',
            'status' => 'ok',
            'time_in' => '09:00',
            'time_out' => '10:00',
            'session_length_total' => 60,
            'pa_service_id' => $this->paService->id,
        ];

        $response = $this->actingAs($this->provider)->putJson("/api/v2/notes/rbt/{$note->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Note updated successfully'
            ]);

        $this->assertDatabaseHas('note_rbts', [
            'id' => $note->id,
            'client_response_to_treatment_this_session' => 'Updated response',
            'status' => 'ok'
        ]);
    }

    /**
     * Test that patch endpoint can partially update note
     */
    public function test_can_patch_note_rbt()
    {
        $note = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'client_response_to_treatment_this_session' => 'Original response',
            'status' => 'pending',
            'pa_service_id' => $this->paService->id,
        ]);

        $patchData = [
            'client_response_to_treatment_this_session' => 'Updated response',
            'status' => 'ok'
        ];

        $response = $this->actingAs($this->provider)->patchJson("/api/v2/notes/rbt/{$note->id}", $patchData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Note updated successfully',
                'data' => [
                    'id' => $note->id,
                    'client_response_to_treatment_this_session' => 'Updated response',
                    'status' => 'ok',
                    'patient_id' => $this->patient->id,
                    'provider_id' => $this->provider->id,
                ]
            ]);

        // Verify only specified fields were updated
        $this->assertDatabaseHas('note_rbts', [
            'id' => $note->id,
            'client_response_to_treatment_this_session' => 'Updated response',
            'status' => 'ok',
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
        ]);
    }

    public function test_can_delete_note_rbt()
    {
        $note = NoteRbt::factory()->create();

        $response = $this->actingAs($this->provider)->deleteJson("/api/v2/notes/rbt/{$note->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Note deleted successfully'
            ]);

        $this->assertSoftDeleted('note_rbts', [
            'id' => $note->id
        ]);
    }

    public function test_can_retrieve_note_rbt()
    {
        $note = NoteRbt::factory()->create();

        $response = $this->actingAs($this->provider)->getJson("/api/v2/notes/rbt/{$note->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'patient_id',
                    'patient_identifier',
                    'provider_id',
                    'supervisor_id',
                    'doctor_id',
                    'session_date',
                    'time_in',
                    'time_out',
                    'time_in2',
                    'time_out2',
                    'session_length_total',
                    'environmental_changes',
                    'maladaptives',
                    'replacements',
                    'interventions',
                    'created_at',
                    'updated_at',
                    'total_units',
                ]
            ]);
    }

    /**
     * Test total units is calculated correctly
     */
    public function test_total_units_is_calculated_correctly()
    {
        $note = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '09:00',
            'time_out' => '11:00',
            'time_in2' => null,
            'time_out2' => null,
        ]);
        $note2 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '09:00',
            'time_out' => '11:15',
            'time_in2' => null,
            'time_out2' => null,
        ]);

        $this->assertEquals(8, $note->total_units);
        $this->assertEquals(9, $note2->total_units);
    }

    public function test_note_rbt_validation_rules()
    {
        $response = $this->postJson('/api/v2/notes/rbt', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['patient_id', 'session_date', 'pa_service_id']);
    }

    public function test_can_list_notes_rbt_with_filters()
    {
        // Create test notes
        NoteRbt::factory()->count(3)->create();

        // Create a note with specific attributes for filtering
        $filteredNote = NoteRbt::factory()->create([
            'session_date' => '2024-01-01',
            'patient_id' => $this->patient->id
        ]);

        // Test basic listing
        $response = $this->getJson('/api/v2/notes/rbt');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ]
            ]);

        // Test with date filter
        $dateFilterResponse = $this->getJson('/api/v2/notes/rbt?date_start=2024-01-01&date_end=2024-01-01');
        $dateFilterResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data');

        // Test with patient filter
        $patientFilterResponse = $this->getJson("/api/v2/notes/rbt?patient_id={$this->patient->id}");
        $patientFilterResponse->assertStatus(200);
    }

    /**
     * Test that show endpoint returns correct note and not just first record
     */
    public function test_show_endpoint_returns_correct_note_rbt()
    {
        // Create multiple notes with distinct data
        $note1 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'client_response_to_treatment_this_session' => 'Response One',
            'pa_service_id' => $this->paService->id,
        ]);

        $note2 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'client_response_to_treatment_this_session' => 'Response Two',
            'pa_service_id' => $this->paService->id,
        ]);

        $note3 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'patient_identifier' => $this->patient->patient_identifier,
            'provider_id' => $this->provider->id,
            'client_response_to_treatment_this_session' => 'Response Three',
            'pa_service_id' => $this->paService->id,
        ]);

        // Request the second note specifically
        $response = $this->getJson("/api/v2/notes/rbt/{$note2->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $note2->id,
                    'client_response_to_treatment_this_session' => 'Response Two'
                ]
            ]);

        // Verify it's not returning the first note
        $response->assertJsonMissing([
            'data' => [
                'id' => $note1->id,
                'client_response_to_treatment_this_session' => 'Response One'
            ]
        ]);
    }

    public function test_time_formats_are_accepted()
    {
        // Test with HH:MM format
        $noteDataHHMM = [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'supervisor_id' => $this->supervisor->id,
            'location_id' => $this->location->id,
            'pa_service_id' => $this->paService->id,
            'session_date' => now()->subDays(1)->format('Y-m-d'),
            'time_in' => '09:30',
            'time_out' => '10:45',
            'time_in2' => '13:15',
            'time_out2' => '14:30'
        ];

        $response = $this->postJson('/api/v2/notes/rbt', $noteDataHHMM);
        $response->assertStatus(201);
        $this->assertDatabaseHas('note_rbts', [
            'time_in' => '09:30',
            'time_out' => '10:45',
            'time_in2' => '13:15',
            'time_out2' => '14:30'
        ]);

        // Test with HH:MM:SS format
        $noteDataHHMMSS = [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'supervisor_id' => $this->supervisor->id,
            'location_id' => $this->location->id,
            'pa_service_id' => $this->paService->id,
            'session_date' => now()->subDays(2)->format('Y-m-d'),
            'time_in' => '09:30:00',
            'time_out' => '10:45:00',
            'time_in2' => '13:15:00',
            'time_out2' => '14:30:00'
        ];

        $response = $this->postJson('/api/v2/notes/rbt', $noteDataHHMMSS);
        $response->assertStatus(201);
        // Verify that HH:MM:SS was converted to HH:MM in the database
        $this->assertDatabaseHas('note_rbts', [
            'time_in' => '09:30',
            'time_out' => '10:45',
            'time_in2' => '13:15',
            'time_out2' => '14:30'
        ]);
    }
}
