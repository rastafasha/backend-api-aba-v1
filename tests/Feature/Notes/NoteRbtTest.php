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
    }

    public function test_can_create_note_rbt()
    {
        $noteData = [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'supervisor_id' => $this->supervisor->id,
            'doctor_id' => $this->doctor->id,
            'location_id' => $this->location->id,
            'insurance_id' => $this->insurance->id,
            'session_date' => $this->faker->date(),
            'time_in' => '09:00:00',
            'time_out' => '10:00:00',
            'time_in2' => '14:00:00',
            'time_out2' => '15:00:00',
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
            'next_session_is_scheduled_for' => $this->faker->date(),
            'provider_signature' => $this->faker->name,
            'provider_credential' => 'RBT',
            'status' => 'pending',
            'cpt_code' => '97153',
            'billed' => false,
            'paid' => false,
            'pa_service_id' => $this->paService->id,
        ];

        $response = $this->postJson('/api/v2/notes/rbt', $noteData);

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

    public function test_can_update_note_rbt()
    {
        $note = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'pa_service_id' => $this->paService->id,
        ]);

        $updatedData = [
            'patient_id' => $this->patient->id,
            'session_date' => $this->faker->date(),
            'doctor_id' => $this->doctor->id,
            'supervisor_id' => $this->supervisor->id,
            'provider_id' => $this->provider->id,
            'client_response_to_treatment_this_session' => 'Updated response',
            'status' => 'ok',
            'time_in' => '09:00:00',
            'time_out' => '10:00:00',
            'session_length_total' => 60,
            'pa_service_id' => $this->paService->id,
        ];

        $response = $this->putJson("/api/v2/notes/rbt/{$note->id}", $updatedData);

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

    public function test_can_delete_note_rbt()
    {
        $note = NoteRbt::factory()->create();

        $response = $this->deleteJson("/api/v2/notes/rbt/{$note->id}");

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

        $response = $this->getJson("/api/v2/notes/rbt/{$note->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'patient_id',
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
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '11:00:00',
            'time_in2' => null,
            'time_out2' => null,
        ]);
        $note2 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '11:08:00',
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
            ->assertJsonValidationErrors(['patient_id', 'session_date', 'doctor_id']);
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
}
