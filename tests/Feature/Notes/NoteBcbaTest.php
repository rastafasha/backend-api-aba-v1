<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Location;
use App\Models\Insurance\Insurance;
use App\Models\Notes\NoteBcba;
use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class NoteBcbaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $patient;
    protected $provider;
    protected $supervisor;
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
        $this->location = Location::factory()->create();
        $this->insurance = Insurance::factory()->create();
    }

    /**
     * Test creating a new BCBA note
     */
    public function test_can_create_note_bcba()
    {
        $noteData = [
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'supervisor_id' => $this->supervisor->id,
            'location_id' => $this->location->id,
            'insurance_id' => $this->insurance->id,
            'pa_service_id' => $this->paService->id,
            'session_date' => $this->faker->date(),
            'time_in' => '09:00:00',
            'time_out' => '10:00:00',
            'session_length_total' => 60,
            'note_description' => $this->faker->paragraph,
            'status' => 'pending',
            'caregiver_goals' => ['goal1' => true, 'goal2' => false],
            'rbt_training_goals' => ['training1' => true, 'training2' => false],
            'meet_with_client_at' => 'Office',
            'billed' => false,
            'paid' => false,
            'cpt_code' => '97151'
        ];

        $response = $this->postJson('/api/v2/notes/bcba', $noteData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Note created successfully'
            ]);

        $this->assertDatabaseHas('note_bcbas', [
            'patient_id' => $noteData['patient_id'],
            'provider_id' => $noteData['provider_id'],
            'session_date' => $noteData['session_date']
        ]);
    }

    /**
     * Test updating an existing BCBA note
     */
    public function test_can_update_note_bcba()
    {
        $note = NoteBcba::factory()->create([
            'patient_id' => $this->patient->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'pa_service_id' => $this->paService->id,
        ]);

        $updatedData = [
            'patient_id' => $this->patient->id,
            'session_date' => $this->faker->date(),
            'note_description' => 'Updated note description',
            'status' => 'ok',
            'time_in' => '09:00:00',
            'time_out' => '10:00:00',
            'session_length_total' => 60
        ];

        $response = $this->putJson("/api/v2/notes/bcba/{$note->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Note updated successfully'
            ]);

        $this->assertDatabaseHas('note_bcbas', [
            'id' => $note->id,
            'note_description' => 'Updated note description',
            'status' => 'ok'
        ]);
    }

    /**
     * Test deleting a BCBA note
     */
    public function test_can_delete_note_bcba()
    {
        $note = NoteBcba::factory()->create();

        $response = $this->deleteJson("/api/v2/notes/bcba/{$note->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Note deleted successfully'
            ]);

        $this->assertSoftDeleted('note_bcbas', [
            'id' => $note->id
        ]);
    }

    /**
     * Test retrieving a single BCBA note
     */
    public function test_can_retrieve_note_bcba()
    {
        $note = NoteBcba::factory()->create();

        $response = $this->getJson("/api/v2/notes/bcba/{$note->id}");

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
                    'session_date',
                    'time_in',
                    'time_out',
                    'session_length_total',
                    'note_description',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /**
     * Test total units is calculated correctly
     */
    public function test_total_units_is_calculated_correctly()
    {
        $note = NoteBcba::factory()->create([
            'pa_service_id' => $this->paService->id,
            'patient_id' => $this->patient->id,
            'cpt_code' => '97155',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '11:00:00',
            'time_in2' => null,
            'time_out2' => null,
        ]);
        $note2 = NoteBcba::factory()->create([
            'pa_service_id' => $this->paService->id,
            'patient_id' => $this->patient->id,
            'cpt_code' => '97155',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '11:08:00',
            'time_in2' => null,
            'time_out2' => null,
        ]);

        $this->assertEquals(8, $note->total_units);
        $this->assertEquals(9, $note2->total_units);
    }

    /**
     * Test BCBA note validation rules
     */
    public function test_note_bcba_validation_rules()
    {
        $response = $this->postJson('/api/v2/notes/bcba', [
            // Sending empty data to trigger validation
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['patient_id', 'session_date']);
    }

    /**
     * Test listing BCBA notes with filters
     */
    public function test_can_list_notes_bcba_with_filters()
    {
        // Create test notes
        NoteBcba::factory()->count(3)->create();

        // Create a note with specific attributes for filtering
        $filteredNote = NoteBcba::factory()->create([
            'session_date' => '2024-01-01',
            'patient_id' => $this->patient->id
        ]);

        // Test basic listing
        $response = $this->getJson('/api/v2/notes/bcba');
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
        $dateFilterResponse = $this->getJson('/api/v2/notes/bcba?date_start=2024-01-01&date_end=2024-01-01');
        $dateFilterResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data');

        // Test with patient filter
        $patientFilterResponse = $this->getJson("/api/v2/notes/bcba?patient_id={$this->patient->id}");
        $patientFilterResponse->assertStatus(200);
    }
}
