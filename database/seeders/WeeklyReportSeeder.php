<?php

namespace Database\Seeders;

use App\Models\Bip\Plan;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WeeklyReportSeeder extends Seeder
{
    public function run()
    {
        // Get all plans
        $plans = Plan::with('objectives')->get();

        foreach ($plans as $plan) {
            // Get mastered and in-progress objectives
            $relevantObjectives = $plan->objectives
                ->filter(function ($objective) {
                    return in_array($objective->status, ['mastered', 'in progress']);
                })
                ->sortBy('order');

            if ($relevantObjectives->isEmpty()) {
                continue; // Skip if no relevant objectives
            }

            foreach ($relevantObjectives as $objective) {
                $startDate = Carbon::parse($objective->initial_date);

                // For mastered objectives, use the end_date
                // For in-progress objectives, use 4 weeks from initial_date
                $endDate = $objective->status === 'mastered'
                    ? Carbon::parse($objective->end_date)
                    : $startDate->copy()->addWeeks(4);

                // Skip if no valid dates
                if (!$startDate || $startDate->isFuture()) {
                    continue;
                }

                // Generate weekly reports
                $currentDate = $startDate->copy()->startOfWeek();
                while ($currentDate->lte($endDate)) {
                    $weekEnd = $currentDate->copy()->endOfWeek();

                    // Calculate target value based on objective
                    $targetValue = $objective->target;

                    // Add randomness (±5)
                    $randomAdjustment = rand(-5, 5);
                    $value = max(0, $targetValue + $randomAdjustment);

                    // Create weekly report
                    WeeklyReport::create([
                        'plan_id' => $plan->id,
                        'week_start' => $currentDate->format('Y-m-d'),
                        'week_end' => $weekEnd->format('Y-m-d'),
                        'value' => $value,
                    ]);

                    $currentDate->addWeek();
                }
            }
        }
    }
}
