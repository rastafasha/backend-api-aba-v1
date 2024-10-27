<?php

namespace App\Services;

use App\Models\PaService;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use Carbon\Carbon;

class UnitCalculationService
{
    public function calculateAvailableUnits(string $patientId, string $serviceId)
    {
        $patient = Patient::where('patient_id', $patientId)->first();

        if (!$patient) {
            return 0;
        }
        // Get the specific PA service
        $paService = PaService::where('id', $serviceId)
            ->where('patient_id', $patient->id)
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$paService) {
            return 0;
        }

        $initialUnits = $paService->n_units;

        // Calculate used units from RBT notes for this specific service
        $usedUnitsRbt = $this->calculateUsedUnitsFromRbtNotes($patientId, $serviceId);

        // Calculate used units from BCBA notes for this specific service
        $usedUnitsBcba = $this->calculateUsedUnitsFromBcbaNotes($patientId, $serviceId);

        // Return remaining units
        return max(0, $initialUnits - ($usedUnitsRbt + $usedUnitsBcba));
    }

    private function calculateUsedUnitsFromRbtNotes(string $patientId, string $serviceId)
    {
        return NoteRbt::where('patient_id', $patientId)
            ->where('pa_service_id', $serviceId)
            ->whereNotNull('time_in')
            ->whereNotNull('time_out')
            ->get()
            ->sum(function ($note) {
                $totalUnits = 0;

                // Calculate units for first session
                if ($note->time_in && $note->time_out) {
                    $minutes = $this->calculateMinutesBetweenTimes($note->time_in, $note->time_out);
                    $totalUnits += $this->convertMinutesToUnits($minutes);
                }

                // Calculate units for second session if exists
                if ($note->time_in2 && $note->time_out2) {
                    $minutes = $this->calculateMinutesBetweenTimes($note->time_in2, $note->time_out2);
                    $totalUnits += $this->convertMinutesToUnits($minutes);
                }

                return $totalUnits;
            });
    }

    private function calculateUsedUnitsFromBcbaNotes(string $patientId, string $serviceId)
    {
        return NoteBcba::where('patient_id', $patientId)
            ->where('pa_service_id', $serviceId)
            ->whereNotNull('time_in')
            ->whereNotNull('time_out')
            ->get()
            ->sum(function ($note) {
                $totalUnits = 0;

                // Calculate units for first session
                if ($note->time_in && $note->time_out) {
                    $minutes = $this->calculateMinutesBetweenTimes($note->time_in, $note->time_out);
                    $totalUnits += $this->convertMinutesToUnits($minutes);
                }

                // Calculate units for second session if exists
                if ($note->time_in2 && $note->time_out2) {
                    $minutes = $this->calculateMinutesBetweenTimes($note->time_in2, $note->time_out2);
                    $totalUnits += $this->convertMinutesToUnits($minutes);
                }

                return $totalUnits;
            });
    }

    private function calculateMinutesBetweenTimes(string $timeIn, string $timeOut): int
    {
        $timeIn = Carbon::parse($timeIn);
        $timeOut = Carbon::parse($timeOut);

        // Handle case where time_out is on the next day
        if ($timeOut < $timeIn) {
            $timeOut->addDay();
        }

        return $timeOut->diffInMinutes($timeIn);
    }

    private function convertMinutesToUnits(int $minutes): int
    {
        // Each unit is 15 minutes, round up to the nearest unit
        return ceil($minutes / 15);
    }
}
