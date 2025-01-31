<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeeklyReportRequest;
use App\Models\WeeklyReport;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedWeeklyReportResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/WeeklyReport")),
 *     @OA\Property(property="first_page_url", type="string", example="http://example.com/api/v2/weekly-reports?page=1"),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=1),
 *     @OA\Property(property="last_page_url", type="string", example="http://example.com/api/v2/weekly-reports?page=1"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string", example="http://example.com/api/v2/weekly-reports"),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer", example=15),
 *     @OA\Property(property="total", type="integer", example=100)
 * )
 */
class WeeklyReportV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/weekly-reports",
     *     summary="Get paginated weekly reports",
     *     description="Retrieves a paginated list of weekly reports with optional filters",
     *     tags={"WeeklyReports"},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         description="Include related models (comma-separated). Options: plan",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="plan_id",
     *         in="query",
     *         description="Filter by plan ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="date_start",
     *         in="query",
     *         description="Start date for filtering (Y-m-d)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="date_end",
     *         in="query",
     *         description="End date for filtering (Y-m-d)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PaginatedWeeklyReportResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = WeeklyReport::query();

        // Filter by plan_id
        if ($request->has('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        // Filter by date range
        if ($request->has('date_start')) {
            $query->where('week_start', '>=', $request->date_start);
        }
        if ($request->has('date_end')) {
            $query->where('week_end', '<=', $request->date_end);
        }

        // Handle includes
        $allowedIncludes = ['plan'];
        $includes = [];
        if ($request->has('include')) {
            $includes = array_filter(
                explode(',', $request->input('include')),
                fn($include) => in_array(trim($include), $allowedIncludes)
            );
        }

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $reports = $query->with($includes)
            ->orderBy('week_start', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $reports
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/weekly-reports",
     *     summary="Create a new weekly report",
     *     description="Creates a new weekly report with the provided data",
     *     tags={"WeeklyReports"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"plan_id", "week_start", "week_end", "value"},
     *             @OA\Property(property="plan_id", type="integer"),
     *             @OA\Property(property="week_start", type="string", format="date"),
     *             @OA\Property(property="week_end", type="string", format="date"),
     *             @OA\Property(property="value", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Report created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Weekly report created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/WeeklyReport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(WeeklyReportRequest $request)
    {
        $report = WeeklyReport::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Weekly report created successfully',
            'data' => $report,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/weekly-reports/{id}",
     *     summary="Get a single weekly report",
     *     description="Retrieves a specific weekly report by its ID",
     *     tags={"WeeklyReports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the weekly report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         description="Include related models (comma-separated). Options: plan",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/WeeklyReport"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Report not found"
     *     )
     * )
     */
    public function show(Request $request, $id)
    {
        // Handle includes
        $allowedIncludes = ['plan'];
        $includes = [];
        if ($request->has('include')) {
            $includes = array_filter(
                explode(',', $request->input('include')),
                fn($include) => in_array(trim($include), $allowedIncludes)
            );
        }

        $report = WeeklyReport::with($includes)->find($id);

        if (!$report) {
            return response()->json([
                'status' => 'error',
                'message' => 'Weekly report not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $report
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/weekly-reports/{id}",
     *     summary="Update a weekly report",
     *     description="Updates an existing weekly report",
     *     tags={"WeeklyReports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the weekly report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"plan_id", "week_start", "week_end", "value"},
     *             @OA\Property(property="plan_id", type="integer"),
     *             @OA\Property(property="week_start", type="string", format="date"),
     *             @OA\Property(property="week_end", type="string", format="date"),
     *             @OA\Property(property="value", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Weekly report updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/WeeklyReport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Report not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(WeeklyReportRequest $request, $id)
    {
        $report = WeeklyReport::findOrFail($id);

        $report->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Weekly report updated successfully',
            'data' => $report,
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/api/v2/weekly-reports/{id}",
     *     summary="Partially update a weekly report",
     *     description="Updates specific fields of an existing weekly report",
     *     tags={"WeeklyReports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the weekly report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="plan_id", type="integer"),
     *             @OA\Property(property="week_start", type="string", format="date"),
     *             @OA\Property(property="week_end", type="string", format="date"),
     *             @OA\Property(property="value", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Weekly report updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/WeeklyReport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Report not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function patch(Request $request, $id)
    {
        $report = WeeklyReport::findOrFail($id);

        $validator = validator($request->all(), array_intersect_key(
            (new WeeklyReportRequest())->rules(),
            $request->all()
        ));

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $report->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Weekly report updated successfully',
            'data' => $report,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/weekly-reports/{id}",
     *     summary="Delete a weekly report",
     *     description="Deletes an existing weekly report",
     *     tags={"WeeklyReports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the weekly report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Weekly report deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Report not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $report = WeeklyReport::find($id);

        if (!$report) {
            return response()->json([
                'status' => 'error',
                'message' => 'Weekly report not found'
            ], 404);
        }

        $report->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Weekly report deleted successfully'
        ]);
    }
}
