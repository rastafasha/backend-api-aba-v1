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

    protected function checkBufferTimeViolation($query, $sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $excludeId = null)
    {
        $query->whereDate('session_date', $sessionDate);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $bufferMinutes = 15; // 15 minutes buffer time required

        return $query->where(function ($query) use ($timeIn, $timeOut, $timeIn2, $timeOut2, $bufferMinutes) {
            if ($timeIn && $timeOut) {
                // Check if any session ends too close to our start time
                $query->where(function ($q) use ($timeIn, $bufferMinutes) {
                    $bufferStart = Carbon::parse($timeIn)->subMinutes($bufferMinutes)->format('H:i');
                    $q->where(function ($q) use ($bufferStart, $timeIn) {
                        $q->whereNotNull('time_out')
                            ->where('time_out', '>', $bufferStart)
                            ->where('time_out', '<=', $timeIn);
                    })->orWhere(function ($q) use ($bufferStart, $timeIn) {
                        $q->whereNotNull('time_out2')
                            ->where('time_out2', '>', $bufferStart)
                            ->where('time_out2', '<=', $timeIn);
                    });
                })
                // Check if any session starts too soon after our end time
                ->orWhere(function ($q) use ($timeOut, $bufferMinutes) {
                    $bufferEnd = Carbon::parse($timeOut)->addMinutes($bufferMinutes)->format('H:i');
                    $q->where(function ($q) use ($timeOut, $bufferEnd) {
                        $q->whereNotNull('time_in')
                            ->where('time_in', '>=', $timeOut)
                            ->where('time_in', '<', $bufferEnd);
                    })->orWhere(function ($q) use ($timeOut, $bufferEnd) {
                        $q->whereNotNull('time_in2')
                            ->where('time_in2', '>=', $timeOut)
                            ->where('time_in2', '<', $bufferEnd);
                    });
                });
            }

            if ($timeIn2 && $timeOut2) {
                // Check if any session ends too close to our second start time
                $query->orWhere(function ($q) use ($timeIn2, $bufferMinutes) {
                    $bufferStart = Carbon::parse($timeIn2)->subMinutes($bufferMinutes)->format('H:i');
                    $q->where(function ($q) use ($bufferStart, $timeIn2) {
                        $q->whereNotNull('time_out')
                            ->where('time_out', '>', $bufferStart)
                            ->where('time_out', '<=', $timeIn2);
                    })->orWhere(function ($q) use ($bufferStart, $timeIn2) {
                        $q->whereNotNull('time_out2')
                            ->where('time_out2', '>', $bufferStart)
                            ->where('time_out2', '<=', $timeIn2);
                    });
                })
                // Check if any session starts too soon after our second end time
                ->orWhere(function ($q) use ($timeOut2, $bufferMinutes) {
                    $bufferEnd = Carbon::parse($timeOut2)->addMinutes($bufferMinutes)->format('H:i');
                    $q->where(function ($q) use ($timeOut2, $bufferEnd) {
                        $q->whereNotNull('time_in')
                            ->where('time_in', '>=', $timeOut2)
                            ->where('time_in', '<', $bufferEnd);
                    })->orWhere(function ($q) use ($timeOut2, $bufferEnd) {
                        $q->whereNotNull('time_in2')
                            ->where('time_in2', '>=', $timeOut2)
                            ->where('time_in2', '<', $bufferEnd);
                    });
                });
            }
        });
    }

    protected function checkProviderBufferTimeViolation($sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $providerId, $excludeId = null)
    {
        // Check RBT notes
        $rbtViolation = $this->checkBufferTimeViolation(
            NoteRbt::where('provider_id', $providerId),
            $sessionDate,
            $timeIn,
            $timeOut,
            $timeIn2,
            $timeOut2,
            $excludeId
        )->exists();

        if ($rbtViolation) {
            return true;
        }

        // Check BCBA notes
        $bcbaViolation = $this->checkBufferTimeViolation(
            NoteBcba::where('provider_id', $providerId),
            $sessionDate,
            $timeIn,
            $timeOut,
            $timeIn2,
            $timeOut2,
            $excludeId
        )->exists();

        return $bcbaViolation;
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
                    $validator->errors()->add('time_in', 'Oops! It looks like there’s an overlap in your schedule. Could you please double-check your times?.');
                    return;
                }
            }

            // Check provider's overlapping sessions and buffer time
            if ($providerId) {
                $providerOverlap = $this->checkProviderOverlap($sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $providerId, $noteId);
                if ($providerOverlap) {
                    $validator->errors()->add('time_in', 'Oops! It seems the time you’re inputting is already assigned to another client. ' .
                        'Please double-check your schedule and make adjustments to avoid overlap.');
                    return;
                }

                // Check buffer time violations
                $bufferViolation = $this->checkProviderBufferTimeViolation($sessionDate, $timeIn, $timeOut, $timeIn2, $timeOut2, $providerId, $noteId);
                if ($bufferViolation) {
                    $validator->errors()->add('time_in', 'Oops! It looks like you haven’t accounted for transition time. Could you please review your schedule?');
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
