<?php

namespace App\Observers;

use App\Models\Notes\NoteRbt;
use App\Models\PaService;

class NoteRbtObserver
{
    public function creating(NoteRbt $note)
    {
        if (!$note->pa_service_id) {
            throw new \Exception('pa_service_id is not set on the note');
        }

        $units = $note->total_units;
        $paService = $note->paService;

        if (!$paService) {
            throw new \Exception('Note must be associated with a PaService (ID: ' . $note->pa_service_id . ')');
        }

        if (!$paService->consumeUnits($units)) {
            throw new \Exception('Insufficient units available in PaService');
        }
    }

    public function deleting(NoteRbt $note)
    {
        // Remove units from spent total when a note is deleted
        $units = $note->total_units;
        $paService = $note->paService;

        $paService->spent_units -= $units;
        $paService->save();
    }

    public function updating(NoteRbt $note)
    {
        // Get the original values before changes
        $originalUnits = $note->getOriginal('total_units');
        $originalPaServiceId = $note->getOriginal('pa_service_id');

        // If time fields that affect units have changed or pa_service_id changed
        if ($note->isDirty(['time_in', 'time_out', 'time_in2', 'time_out2', 'pa_service_id'])) {
            // First, restore the original units
            $originalPaService = PaService::find($originalPaServiceId);
            if ($originalPaService) {
                $originalPaService->spent_units -= $originalUnits;
                $originalPaService->save();
            }

            // If we're changing PA services
            if ($note->isDirty('pa_service_id')) {
                $newPaService = PaService::find($note->pa_service_id);
                if (!$newPaService) {
                    throw new \Exception('Note must be associated with a PaService');
                }
            } else {
                $newPaService = $originalPaService;
            }

            // Calculate and consume new units
            $newUnits = $note->total_units;
            if (!$newPaService->consumeUnits($newUnits)) {
                // If consumption fails, restore original state and throw exception
                if ($originalPaService) {
                    $originalPaService->spent_units += $originalUnits;
                    $originalPaService->save();
                }
                throw new \Exception('Insufficient units available in PaService');
            }
        }
    }
}
