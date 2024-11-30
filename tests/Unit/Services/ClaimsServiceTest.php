<?php

namespace Tests\Unit\Services;

use App\Models\Insurance\Insurance;
use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Services\ClaimsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClaimsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ClaimsService $claimsService;
    protected Patient $patient;
    protected Insurance $insurance;

    protected function setUp(): void
    {
        parent::setUp();

        // Create necessary services
        $this->claimsService = app(ClaimsService::class);

        // Create a test patient
        $this->patient = Patient::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'patient_identifier' => '12345',
            'birth_date' => '1990-01-01',
            'gender' => 1,
            'address' => '123 Test St',
            'city' => 'Test City',
            'state' => 'FL',
            'zip' => '12345',
            'diagnosis_code' => 'F84.0',
        ]);

        // Create test insurance
        $this->insurance = Insurance::factory()->create([
            'name' => 'Test Insurance',
            'payer_id' => 'TEST123',
            'street' => '456 Insurance Ave',
            'city' => 'Insurance City',
            'state' => 'FL',
            'zip' => '67890',
            'services' => [
                [
                    'code' => '97153',
                    'unit_prize' => 50.00
                ],
                [
                    'code' => '97155',
                    'unit_prize' => 75.00
                ]
            ]
        ]);

        $this->patient->update(['insurer_id' => $this->insurance->id]);
    }

    /** @test */
    public function it_generates_claim_content_from_rbt_notes()
    {
        // Create RBT notes with morning session (2 hours = 8 units)
        $rbtNote = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '11:00:00',
            'time_in2' => null,
            'time_out2' => null,
        ]);

        // Generate claim content
        $content = $this->claimsService->generateFromNotes(
            [$rbtNote->id],
            []
        );

        // Assert content is generated
        $this->assertNotEmpty($content);

        // Assert content contains expected data
        $this->assertStringContainsString('97153', $content);
        $this->assertStringContainsString($this->patient->id, $content);
        $this->assertStringContainsString($this->insurance->payer_id, $content);
    }

    /** @test */
    public function it_generates_claim_content_from_bcba_notes()
    {
        // Create BCBA note with morning session (1 hour = 4 units)
        $bcbaNote = NoteBcba::factory()->create([
            'patient_id' => $this->patient->id,
            'cpt_code' => '97155',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '10:00:00',
            'time_in2' => null,
            'time_out2' => null,
        ]);

        // Generate claim content
        $content = $this->claimsService->generateFromNotes(
            [],
            [$bcbaNote->id]
        );

        // Assert content is generated
        $this->assertNotEmpty($content);

        // Assert content contains expected data
        $this->assertStringContainsString('97155', $content);
        $this->assertStringContainsString($this->patient->id, $content);
        $this->assertStringContainsString($this->insurance->payer_id, $content);
    }

    /** @test */
    public function it_calculates_correct_total_amounts()
    {
        // Create RBT note (2 hours = 8 units)
        $rbtNote = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '11:00:00',
            'time_in2' => null,
            'time_out2' => null,
        ]); // 8 units * $50 = $400

        // Create RBT note 2 (1 hour = 4 units)
        $rbtNote2 = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '13:00:00',
            'time_out' => '14:00:00',
            'time_in2' => null,
            'time_out2' => null,
        ]); // 4 units * $50 = $200

        // Generate claim content
        $content = $this->claimsService->generateFromNotes(
            [$rbtNote->id, $rbtNote2->id],
            []
        );

        // Expected total: $400 + $200 = $600
        $this->assertStringContainsString('600.00', $content);
    }

    /** @test */
    public function it_handles_split_sessions()
    {
        // Create RBT note with split session
        $rbtNote = NoteRbt::factory()->create([
            'patient_id' => $this->patient->id,
            'cpt_code' => '97153',
            'session_date' => '2024-01-15',
            'time_in' => '09:00:00',
            'time_out' => '10:00:00',  // 1 hour = 4 units
            'time_in2' => '14:00:00',
            'time_out2' => '15:00:00', // 1 hour = 4 units
        ]); // Total: 8 units * $50 = $400

        // Create BCBA note with split session
        $bcbaNote = NoteBcba::factory()->create([
            'patient_id' => $this->patient->id,
            'cpt_code' => '97155',
            'session_date' => '2024-01-15',
            'time_in' => '11:00:00',
            'time_out' => '12:00:00',  // 1 hour = 4 units
            'time_in2' => '13:00:00',
            'time_out2' => '13:30:00', // 30 min = 2 units
        ]); // Total: 6 units * $75 = $450

        // Generate claim content
        $content = $this->claimsService->generateFromNotes(
            [$rbtNote->id],
            [$bcbaNote->id]
        );

        // Assert each claim amount is present separately
        $this->assertStringContainsString('400.00', $content);
        $this->assertStringContainsString('450.00', $content);
    }

    /** @test */
    public function it_handles_empty_notes_arrays()
    {
        $content = $this->claimsService->generateFromNotes([], []);
        $this->assertIsString($content);
        $this->assertEmpty($content);
    }

    /** @test */
    public function it_handles_invalid_note_ids()
    {
        $content = $this->claimsService->generateFromNotes([999999], [999999]);
        $this->assertIsString($content);
        $this->assertEmpty($content);
    }
}
