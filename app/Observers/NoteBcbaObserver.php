<?php

namespace App\Observers;

use App\Models\Notes\NoteBcba;

class NoteBcbaObserver
{
    public function creating(NoteBcba $note)
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

    public function deleting(NoteBcba $note)
    {
        // Restore units when a note is deleted
        $units = $note->total_units;
        $paService = $note->paService;

        $paService->remaining_units += $units;
        $paService->save();
    }
}
