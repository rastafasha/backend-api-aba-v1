<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\CrisisPlan;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedCrisisPlanResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CrisisPlan")),
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
class CrisisPlanV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/crisis-plans",
     *     summary="Get paginated crisis plans",
     *     description="Retrieves a paginated list of crisis plans with optional filters",
     *     tags={"Admin/Crisis Plans"},
     *     @OA\Parameter(
     *         name="bip_id",
     *         in="query",
     *         description="Filter by BIP ID",
     *         required=false,
     *         @OA\Schema(type="integer")
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
     *                 ref="#/components/schemas/PaginatedCrisisPlanResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = CrisisPlan::query();

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        // if ($request->has('patient_identifier')) {
        //     $query->where('patient_identifier', $request->patient_identifier);
        // }

        $perPage = $request->input('per_page', 15);
        $crisisPlans = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $crisisPlans
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/crisis-plans",
     *     summary="Create a new crisis plan",
     *     description="Creates a new crisis plan with the provided data",
     *     tags={"Admin/Crisis Plans"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"patient_identifier"},
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="patient_identifier", type="string"),
     *             @OA\Property(property="crisis_description", type="string"),
     *             @OA\Property(property="crisis_note", type="string"),
     *             @OA\Property(property="caregiver_requirements_for_prevention_of_crisis", type="string"),
     *             @OA\Property(property="risk_factors", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="suicidalities", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="homicidalities", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Crisis plan created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Crisis plan created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/CrisisPlan")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = CrisisPlan::validate($request->all());

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $crisisPlan = CrisisPlan::create($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Crisis plan created successfully',
            'data' => $crisisPlan
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/crisis-plans/{id}",
     *     summary="Get a single crisis plan",
     *     description="Retrieves a specific crisis plan by its ID",
     *     tags={"Admin/Crisis Plans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the crisis plan",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/CrisisPlan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Crisis plan not found"
     *     )
     * )
     */
    public function show($id)
    {
        $crisisPlan = CrisisPlan::find($id);

        if (!$crisisPlan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Crisis plan not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $crisisPlan
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/crisis-plans/{id}",
     *     summary="Update a crisis plan",
     *     description="Updates an existing crisis plan",
     *     tags={"Admin/Crisis Plans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the crisis plan",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="patient_identifier", type="string"),
     *             @OA\Property(property="crisis_description", type="string"),
     *             @OA\Property(property="crisis_note", type="string"),
     *             @OA\Property(property="caregiver_requirements_for_prevention_of_crisis", type="string"),
     *             @OA\Property(property="risk_factors", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="suicidalities", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="homicidalities", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Crisis plan updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Crisis plan not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $crisisPlan = CrisisPlan::find($id);

        if (!$crisisPlan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Crisis plan not found'
            ], 404);
        }

        $validated = CrisisPlan::validate($request->all(), true);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $crisisPlan->update($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Crisis plan updated successfully',
            'data' => $crisisPlan
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/crisis-plans/{id}",
     *     summary="Delete a crisis plan",
     *     description="Deletes an existing crisis plan",
     *     tags={"Admin/Crisis Plans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the crisis plan",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Crisis plan deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Crisis plan not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $crisisPlan = CrisisPlan::find($id);

        if (!$crisisPlan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Crisis plan not found'
            ], 404);
        }

        $crisisPlan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Crisis plan deleted successfully'
        ]);
    }
}
