<?php

namespace App\Services;

use App\Models\Notes\NoteRbt;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WeeklyReportService
{
    /**
     * Generate weekly reports for a given period and patient
     *
     * @param string $startDate
     * @param string $endDate
     * @param int $patientId
     * @return Collection
     */
    public function generateReports(string $startDate, string $endDate, int $patientId): Collection
    {
        // Convert dates to Carbon instances
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Adjust to get complete weeks (Sunday to Saturday)
        $adjustedStart = $start->copy()->startOfWeek(Carbon::SUNDAY);
        $adjustedEnd = $end->copy()->endOfWeek(Carbon::SATURDAY);

        // Get all RBT notes for the period
        $notes = NoteRbt::where('patient_id', $patientId)
            ->whereBetween('session_date', [$adjustedStart, $adjustedEnd])
            ->get();

        // Group notes by week
        $weeklyNotes = $this->groupNotesByWeek($notes);

        // Generate reports for each week
        $reports = new Collection();

        foreach ($weeklyNotes as $weekStart => $weekNotes) {
            $weekEnd = Carbon::parse($weekStart)->endOfWeek(Carbon::SATURDAY);

            // Process maladaptive plans
            $maladaptiveReports = $this->processMaladaptivePlans($weekNotes, $weekStart, $weekEnd);
            $reports = $reports->concat($maladaptiveReports);

            // Process replacement plans
            $replacementReports = $this->processReplacementPlans($weekNotes, $weekStart, $weekEnd);
            $reports = $reports->concat($replacementReports);
        }

        return $reports;
    }

    /**
     * Group notes by week starting on Sunday
     *
     * @param Collection $notes
     * @return Collection
     */
    private function groupNotesByWeek(Collection $notes): Collection
    {
        return $notes->groupBy(function ($note) {
            return Carbon::parse($note->session_date)->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        });
    }

    /**
     * Process maladaptive plans and generate weekly reports
     *
     * @param Collection $weekNotes
     * @param string $weekStart
     * @param Carbon $weekEnd
     * @return Collection
     */
    private function processMaladaptivePlans(Collection $weekNotes, string $weekStart, Carbon $weekEnd): Collection
    {
        $maladaptivePlans = [];

        // Collect all maladaptive occurrences by plan
        foreach ($weekNotes as $note) {
            $maladaptives = is_string($note->maladaptives) ? json_decode($note->maladaptives, true) : $note->maladaptives;

            if (!empty($maladaptives) && is_array($maladaptives)) {
                foreach ($maladaptives as $maladaptive) {
                    if (!isset($maladaptive['id']) || !isset($maladaptive['ocurrences'])) {
                        continue;
                    }

                    if (!isset($maladaptivePlans[$maladaptive['id']])) {
                        $maladaptivePlans[$maladaptive['id']] = [];
                    }

                    $maladaptivePlans[$maladaptive['id']][] = $maladaptive['ocurrences'];
                }
            }
        }

        // Generate or update reports for each maladaptive plan
        return collect($maladaptivePlans)->map(function ($occurrences, $planId) use ($weekStart, $weekEnd) {
            $meanOccurrences = round(collect($occurrences)->average(), 2);

            return WeeklyReport::updateOrCreate(
                [
                    'plan_id' => $planId,
                    'week_start' => $weekStart,
                ],
                [
                    'week_end' => $weekEnd->format('Y-m-d'),
                    'value' => $meanOccurrences
                ]
            );
        });
    }

    /**
     * Process replacement plans and generate weekly reports
     *
     * @param Collection $weekNotes
     * @param string $weekStart
     * @param Carbon $weekEnd
     * @return Collection
     */
    private function processReplacementPlans(Collection $weekNotes, string $weekStart, Carbon $weekEnd): Collection
    {
        $replacementPlans = [];

        // Collect all replacement data by plan
        foreach ($weekNotes as $note) {
            $replacements = is_string($note->replacements) ? json_decode($note->replacements, true) : $note->replacements;

            if (!empty($replacements) && is_array($replacements)) {
                foreach ($replacements as $replacement) {
                    if (
                        !isset($replacement['id']) ||
                        !isset($replacement['total_trials']) ||
                        !isset($replacement['correct_responses'])
                    ) {
                        continue;
                    }

                    if (!isset($replacementPlans[$replacement['id']])) {
                        $replacementPlans[$replacement['id']] = [];
                    }

                    $replacementPlans[$replacement['id']][] = [
                        'total_trials' => $replacement['total_trials'],
                        'correct_responses' => $replacement['correct_responses']
                    ];
                }
            }
        }

        // Generate or update reports for each replacement plan
        return collect($replacementPlans)->map(function ($trials, $planId) use ($weekStart, $weekEnd) {
            $totalTrials = collect($trials)->sum('total_trials');
            $totalCorrect = collect($trials)->sum('correct_responses');

            $percentageCorrect = $totalTrials > 0
                ? round(($totalCorrect / $totalTrials) * 100, 2)
                : 0;

            return WeeklyReport::updateOrCreate(
                [
                    'plan_id' => $planId,
                    'week_start' => $weekStart,
                ],
                [
                    'week_end' => $weekEnd->format('Y-m-d'),
                    'value' => $percentageCorrect
                ]
            );
        });
    }
}
