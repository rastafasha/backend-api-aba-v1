<?php

namespace App\Http\Requests\Notes\Traits;

use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

trait ValidatesTimeLimits
{
    protected function validateTimeLimits(Validator $validator)
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();

            if (!isset($data['session_date']) || !isset($data['patient_id'])) {
                return;
            }

            $sessionDate = Carbon::parse($data['session_date']);
            $noteId = $this->route('id'); // For updates

            // Calculate total minutes for the new note
            $timeIn = $data['time_in'] ?? null;
            $timeOut = $data['time_out'] ?? null;
            $timeIn2 = $data['time_in2'] ?? null;
            $timeOut2 = $data['time_out2'] ?? null;

            $newNoteMinutes = $this->calculateNewNoteMinutes($timeIn, $timeOut, $timeIn2, $timeOut2);

            // Check weekly limit first
            $weeklyMinutes = $this->calculateWeeklyMinutes($data['patient_id'], $sessionDate, $noteId);
            if (($weeklyMinutes + $newNoteMinutes) > (40 * 60)) { // 40 hours = 2400 minutes
                $validator->errors()->add(
                    'time_in',
                    'Oops! It looks like you\'ve reached the maximum allowable hours for the week. Please review your schedule and adjust accordingly.'
                );
                return;
            }

            // Then check daily limit
            $dailyMinutes = $this->calculateDailyMinutes($data['patient_id'], $sessionDate, $noteId);
            if (($dailyMinutes + $newNoteMinutes) > (10 * 60)) { // 10 hours = 600 minutes
                $validator->errors()->add(
                    'time_in',
                    'Oops! It looks like you\'ve reached the maximum allowable hours for the day. Please review your schedule and adjust accordingly.'
                );
                return;
            }
        });
    }

    protected function calculateDailyMinutes($patientId, $date, $excludeId = null)
    {
        // Get RBT notes for the day
        $rbtQuery = NoteRbt::where('patient_id', $patientId)
            ->whereDate('session_date', $date);

        if ($excludeId) {
            $rbtQuery->where('id', '!=', $excludeId);
        }

        $rbtMinutes = $rbtQuery->get()->sum('total_minutes');

        // Get BCBA notes for the day
        $bcbaQuery = NoteBcba::where('patient_id', $patientId)
            ->whereDate('session_date', $date);

        if ($excludeId) {
            $bcbaQuery->where('id', '!=', $excludeId);
        }

        $bcbaMinutes = $bcbaQuery->get()->sum('total_minutes');

        return $rbtMinutes + $bcbaMinutes;
    }

    protected function calculateWeeklyMinutes($patientId, $date, $excludeId = null)
    {
        $weekStart = $date->copy()->startOfWeek();
        $weekEnd = $date->copy()->endOfWeek();

        // Get RBT notes for the week
        $rbtQuery = NoteRbt::where('patient_id', $patientId)
            ->whereBetween('session_date', [$weekStart, $weekEnd]);

        if ($excludeId) {
            $rbtQuery->where('id', '!=', $excludeId);
        }

        $rbtMinutes = $rbtQuery->get()->sum('total_minutes');

        // Get BCBA notes for the week
        $bcbaQuery = NoteBcba::where('patient_id', $patientId)
            ->whereBetween('session_date', [$weekStart, $weekEnd]);

        if ($excludeId) {
            $bcbaQuery->where('id', '!=', $excludeId);
        }

        $bcbaMinutes = $bcbaQuery->get()->sum('total_minutes');

        return $rbtMinutes + $bcbaMinutes;
    }

    protected function calculateNewNoteMinutes($timeIn, $timeOut, $timeIn2, $timeOut2)
    {
        $totalMinutes = 0;

        if ($timeIn && $timeOut) {
            $start = Carbon::parse($timeIn);
            $end = Carbon::parse($timeOut);
            $totalMinutes += $end->diffInMinutes($start);
        }

        if ($timeIn2 && $timeOut2) {
            $start = Carbon::parse($timeIn2);
            $end = Carbon::parse($timeOut2);
            $totalMinutes += $end->diffInMinutes($start);
        }

        return $totalMinutes;
    }
}
