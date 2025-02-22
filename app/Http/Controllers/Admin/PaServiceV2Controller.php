<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\PaServiceRequest;

/**
 * @OA\Schema(
 *     schema="PaginatedPaServiceResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PaService")),
 *     @OA\Property(property="first_page_url", type="string"),
 *     @OA\Property(property="from", type="integer"),
 *     @OA\Property(property="last_page", type="integer"),
 *     @OA\Property(property="last_page_url", type="string"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string"),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer"),
 *     @OA\Property(property="total", type="integer")
 * )
 */
class PaServiceV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/pa-services",
     *     summary="List all PA services",
     *     description="Retrieve a paginated list of PA services with optional filters",
     *     tags={"PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="query",
     *         description="Filter PA services by patient ID",
     *         required=false,
     *         @OA\Schema(type="string")
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
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PaginatedPaServiceResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = PaService::query();

        // Apply filters
        if ($request->has('patient_id')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('id', $request->patient_id);
            });
        }


        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $paServices = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $paServices
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/pa-services",
     *     summary="Create a new PA service",
     *     tags={"PA Services"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"patient_id", "pa_service", "cpt", "n_units", "start_date", "end_date"},
     *             @OA\Property(property="patient_id", type="string", example="123"),
     *             @OA\Property(property="pa_service", type="string", example="Behavioral Analysis"),
     *             @OA\Property(property="cpt", type="string", example="97151"),
     *             @OA\Property(property="n_units", type="integer", example=8),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-04-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PA service created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="PA service created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/PaService")
     *         )
     *     )
     * )
     */
    public function store(PaServiceRequest $request)
    {
        $validated = $request->validated();
        $paService = PaService::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'PA service created successfully',
            'data' => $paService
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/pa-services/{id}",
     *     summary="Get PA service by ID",
     *     tags={"PA Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="PA service ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/PaService")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $paService = PaService::find($id);

        if (!$paService) {
            return response()->json([
                'status' => 'error',
                'message' => 'PA service not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $paService
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/pa-services/{id}",
     *     summary="Update a PA service",
     *     tags={"PA Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="PA service ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pa_service", type="string"),
     *             @OA\Property(property="cpt", type="string"),
     *             @OA\Property(property="n_units", type="integer"),
     *             @OA\Property(property="start_date", type="string", format="date"),
     *             @OA\Property(property="end_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PA service updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="PA service updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/PaService")
     *         )
     *     )
     * )
     */
    public function update(PaServiceRequest $request, $id)
    {
        $paService = PaService::findOrFail($id);
        $validated = $request->validated();
        $paService->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'PA service updated successfully',
            'data' => $paService->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/pa-services/{id}",
     *     summary="Delete a PA service",
     *     tags={"PA Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PA service deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="PA service deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $paService = PaService::find($id);

        if (!$paService) {
            return response()->json([
                'status' => 'error',
                'message' => 'PA service not found'
            ], 404);
        }

        $paService->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'PA service deleted successfully'
        ]);
    }
}
