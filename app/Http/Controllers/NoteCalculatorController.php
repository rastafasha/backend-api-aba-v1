<?php

namespace App\Http\Controllers;

use App\Models\PaService;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoteCalculatorController extends Controller
{
    /**
     * Calculate unit usage statistics for both RBT and BCBA notes
     *
     * @param Request $request
     * @param string $paServiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateUnits(Request $request, $paServiceId)
    {
        $paService = PaService::findOrFail($paServiceId);

        // Calculate weeks between start and end date
        $startDate = Carbon::parse($paService->start_date);
        $endDate = Carbon::parse($paService->end_date);
        $totalWeeks = ceil($startDate->diffInDays($endDate) / 7);

        // Calculate average units per week
        $averageUnitsPerWeek = ceil($paService->n_units / $totalWeeks);

        // Get current week's start (Monday) and end (Sunday)
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Calculate used units this week from both RBT and BCBA notes
        $usedUnitsThisWeek = $this->getUsedUnitsForWeek(
            $paServiceId,
            $weekStart,
            $weekEnd
        );

        // Calculate remaining units for this week
        $remainingUnits = max(0, $averageUnitsPerWeek - $usedUnitsThisWeek);

        return response()->json([
            'pa_service_id' => $paServiceId,
            'total_units' => $paService->n_units,
            'average_units_per_week' => $averageUnitsPerWeek,
            'used_units_this_week' => $usedUnitsThisWeek,
            'remaining_units_this_week' => $remainingUnits,
            'week_start_date' => $weekStart->toDateString(),
            'week_end_date' => $weekEnd->toDateString()
        ]);
    }

    /**
     * Get used units for a specific week from both RBT and BCBA notes
     */
    private function getUsedUnitsForWeek(string $paServiceId, Carbon $weekStart, Carbon $weekEnd)
    {
        // Get RBT notes units
        $rbtUnits = NoteRbt::where('pa_service_id', $paServiceId)
            ->whereBetween('session_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->get()
            ->sum('total_units');

        // Get BCBA notes units
        $bcbaUnits = NoteBcba::where('pa_service_id', $paServiceId)
            ->whereBetween('session_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->get()
            ->sum('total_units');

        return $rbtUnits + $bcbaUnits;
    }
}
