<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Services\WeeklyReportService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeeklyReportGeneratorV2Controller extends Controller
{
    private WeeklyReportService $weeklyReportService;

    public function __construct(WeeklyReportService $weeklyReportService)
    {
        $this->weeklyReportService = $weeklyReportService;
    }

    /**
     * Generate weekly reports for a patient within a date range
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        // Validate request parameters
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|integer|exists:patients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get validated data
            $patientId = $request->input('patient_id');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Additional date range validation
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);

            if ($end->diffInDays($start) > 365) {
                return response()->json([
                    'message' => 'Date range cannot exceed 1 year'
                ], 422);
            }

            // Check if patient exists (even though validator checked exists rule)
            $patient = Patient::find($patientId);
            if (!$patient) {
                return response()->json([
                    'message' => 'Patient not found'
                ], 404);
            }

            // Generate reports using the service
            $reports = $this->weeklyReportService->generateReports($startDate, $endDate, $patientId);

            // Return the response
            return response()->json([
                'message' => 'Weekly reports generated successfully',
                'data' => [
                    'patient_id' => $patientId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'reports' => $reports
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while generating reports',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
