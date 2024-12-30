<?php

namespace App\Http\Requests\Notes\Traits;

use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

trait ValidatesTimeOverlap
{
    protected function checkTimeOverlap($query, $sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $excludeId = null)
    {
        $query->whereDate('session_date', $sessionDate);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->where(function ($query) use ($timeIn, $timeOut, $timeIn2, $timeOut2) {
            // Check morning session overlap if exists
            if ($timeIn && $timeOut) {
                $query->where(function ($q) use ($timeIn, $timeOut) {
                    // Check overlap with other morning sessions
                    $q->where(function ($q) use ($timeIn, $timeOut) {
                        $q->whereNotNull('time_in')
                            ->whereNotNull('time_out')
                            ->where('time_in', '<', $timeOut)
                            ->where('time_out', '>', $timeIn);
                    })
                    // Check overlap with other afternoon sessions
                    ->orWhere(function ($q) use ($timeIn, $timeOut) {
                        $q->whereNotNull('time_in2')
                            ->whereNotNull('time_out2')
                            ->where('time_in2', '<', $timeOut)
                            ->where('time_out2', '>', $timeIn);
                    });
                });
            }

            // Check afternoon session overlap if exists
            if ($timeIn2 && $timeOut2) {
                $query->orWhere(function ($q) use ($timeIn2, $timeOut2) {
                    // Check overlap with other morning sessions
                    $q->where(function ($q) use ($timeIn2, $timeOut2) {
                        $q->whereNotNull('time_in')
                            ->whereNotNull('time_out')
                            ->where('time_in', '<', $timeOut2)
                            ->where('time_out', '>', $timeIn2);
                    })
                    // Check overlap with other afternoon sessions
                    ->orWhere(function ($q) use ($timeIn2, $timeOut2) {
                        $q->whereNotNull('time_in2')
                            ->whereNotNull('time_out2')
                            ->where('time_in2', '<', $timeOut2)
                            ->where('time_out2', '>', $timeIn2);
                    });
                });
            }
        });
    }

    protected function validateTimeOverlap(Validator $validator)
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();

            if (!isset($data['session_date'])) {
                return;
            }

            $sessionDate = Carbon::parse($data['session_date'])->toDateString();
            $timeIn = $data['time_in'] ?? null;
            $timeOut = $data['time_out'] ?? null;
            $timeIn2 = $data['time_in2'] ?? null;
            $timeOut2 = $data['time_out2'] ?? null;
            $patientId = $data['patient_id'] ?? null;
            $providerId = $data['provider_id'] ?? null;
            $noteId = $this->route('id'); // For updates

            if (!$timeIn && !$timeIn2) {
                return;
            }

            // Check patient's overlapping sessions
            if ($patientId) {
                $patientOverlap = $this->checkPatientOverlap($sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $noteId);
                if ($patientOverlap) {
                    $validator->errors()->add('time_in', 'The patient has another session scheduled during this time.');
                    return;
                }
            }

            // Check provider's overlapping sessions
            if ($providerId) {
                $providerOverlap = $this->checkProviderOverlap($sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $providerId, $noteId);
                if ($providerOverlap) {
                    $validator->errors()->add('time_in', 'The provider has another session scheduled during this time.');
                    return;
                }
            }
        });
    }

    protected function checkPatientOverlap($sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $excludeId = null)
    {
        // Check RBT notes
        $rbtOverlap = $this->checkTimeOverlap(
            NoteRbt::where('patient_id', $this->patient_id),
            $sessionDate,
            $timeIn,
            $timeOut,
            $timeIn2,
            $timeOut2,
            $excludeId
        )->exists();

        if ($rbtOverlap) {
            return true;
        }

        // Check BCBA notes
        $bcbaOverlap = $this->checkTimeOverlap(
            NoteBcba::where('patient_id', $this->patient_id),
            $sessionDate,
            $timeIn,
            $timeOut,
            $timeIn2,
            $timeOut2,
            $excludeId
        )->exists();

        return $bcbaOverlap;
    }

    protected function checkProviderOverlap($sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $providerId, $excludeId = null)
    {
        // Check RBT notes
        $rbtOverlap = $this->checkTimeOverlap(
            NoteRbt::where('provider_id', $providerId),
            $sessionDate,
            $timeIn,
            $timeOut,
            $timeIn2,
            $timeOut2,
            $excludeId
        )->exists();

        if ($rbtOverlap) {
            return true;
        }

        // Check BCBA notes
        $bcbaOverlap = $this->checkTimeOverlap(
            NoteBcba::where('provider_id', $providerId),
            $sessionDate,
            $timeIn,
            $timeOut,
            $timeIn2,
            $timeOut2,
            $excludeId
        )->exists();

        return $bcbaOverlap;
    }
}
