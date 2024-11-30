<?php

namespace Tests\Unit\Observers;

use App\Models\Notes\NoteBcba;
use Tests\TestCase;
use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteBcbaObserverTest extends TestCase
{
    use RefreshDatabase;

    private function createNoteWithTime($timeIn, $timeOut, $timeIn2 = null, $timeOut2 = null, $paService = null)
    {
        if (!$paService) {
            $paService = PaService::factory()->create([
                'n_units' => 20,
                'spent_units' => 0,
            ]);
        }

        $patient = Patient::factory()->create();

        return NoteBcba::factory()->create([
            'patient_id' => $patient->id,
            'pa_service_id' => $paService->id,
            'time_in' => $timeIn,
            'time_out' => $timeOut,
            'time_in2' => $timeIn2,
            'time_out2' => $timeOut2,
            'session_date' => now(),
            'cpt_code' => '97153',
        ]);
    }

    public function test_creating_note_consumes_units_from_pa_service()
    {
        $paService = PaService::factory()->create([
            'n_units' => 20,
            'spent_units' => 0,
        ]);

        // Create a note that will consume 8 units (2 hours)
        $note = $this->createNoteWithTime(
            '09:00:00',
            '11:00:00',
            null,
            null,
            $paService
        );

        // Refresh PaService from database
        $paService->refresh();

        $this->assertEquals(8, $paService->spent_units);
    }

    public function test_deleting_note_restores_units_to_pa_service()
    {
        $paService = PaService::factory()->create([
            'n_units' => 20,
            'spent_units' => 0,
        ]);

        $note = $this->createNoteWithTime(
            '09:00:00',
            '11:00:00',
            null,
            null,
            $paService
        );

        $paService->refresh();
        $this->assertEquals(8, $paService->spent_units);

        // Delete the note
        $note->delete();

        $paService->refresh();
        $this->assertEquals(0, $paService->spent_units);
    }

    public function test_updating_note_time_adjusts_units()
    {
        $paService = PaService::factory()->create([
            'n_units' => 20,
            'spent_units' => 0,
        ]);

        $note = $this->createNoteWithTime(
            '09:00:00',
            '11:00:00',
            null,
            null,
            $paService
        );

        $paService->refresh();
        $this->assertEquals(8, $paService->spent_units);

        // Update to 3 hours (12 units)
        $note->time_out = '12:00:00';
        $note->save();

        $paService->refresh();
        $this->assertEquals(12, $paService->spent_units);
    }

    public function test_updating_note_pa_service_transfers_units()
    {
        $originalPaService = PaService::factory()->create([
            'n_units' => 20,
            'spent_units' => 0,
        ]);

        $newPaService = PaService::factory()->create([
            'n_units' => 20,
            'spent_units' => 0,
        ]);

        $note = $this->createNoteWithTime(
            '09:00:00',
            '11:00:00',
            null,
            null,
            $originalPaService
        );

        $originalPaService->refresh();
        $this->assertEquals(8, $originalPaService->spent_units);

        // Change PA service
        $note->pa_service_id = $newPaService->id;
        $note->save();

        $originalPaService->refresh();
        $newPaService->refresh();

        $this->assertEquals(0, $originalPaService->spent_units);
        $this->assertEquals(8, $newPaService->spent_units);
    }

    public function test_insufficient_units_throws_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient units available in PaService');

        $paService = PaService::factory()->create([
            'n_units' => 4, // Only 4 units available
            'spent_units' => 0,
        ]);

        $this->createNoteWithTime(
            '09:00:00',
            '11:00:00',
            null,
            null,
            $paService
        ); // Requires 8 units
    }

    public function test_split_session_calculates_units_correctly()
    {
        $paService = PaService::factory()->create([
            'n_units' => 20,
            'spent_units' => 0,
        ]);

        $note = $this->createNoteWithTime(
            '09:00:00',
            '10:00:00',
            '14:00:00',
            '15:00:00',
            $paService
        );

        $paService->refresh();
        $this->assertEquals(8, $paService->spent_units); // 2 hours total = 8 units
    }
}
