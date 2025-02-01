<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedRecommendationResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Recommendation")),
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
class RecommendationV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/recommendations",
     *     summary="Get paginated recommendations",
     *     description="Retrieves a paginated list of recommendations with optional filters",
     *     tags={"Recommendations"},
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
     *                 ref="#/components/schemas/PaginatedRecommendationResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Recommendation::query();

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        $perPage = $request->input('per_page', 15);
        $recommendations = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $recommendations
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/recommendations",
     *     summary="Create a new recommendation",
     *     description="Creates a new recommendation with the provided data",
     *     tags={"Recommendations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id", "cpt", "description_service", "num_units", "breakdown_per_week", "location"},
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="cpt", type="string"),
     *             @OA\Property(property="description_service", type="string"),
     *             @OA\Property(property="num_units", type="integer"),
     *             @OA\Property(property="breakdown_per_week", type="string"),
     *             @OA\Property(property="location", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Recommendation created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Recommendation created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Recommendation")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bip_id' => 'required|exists:bips,id',
            'cpt' => 'required|string',
            'description_service' => 'required|string',
            'num_units' => 'required|integer',
            'breakdown_per_week' => 'required|string',
            'location' => 'required|string',
        ]);

        $recommendation = Recommendation::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Recommendation created successfully',
            'data' => $recommendation
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/recommendations/{id}",
     *     summary="Get a single recommendation",
     *     description="Retrieves a specific recommendation by its ID",
     *     tags={"Recommendations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the recommendation",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Recommendation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recommendation not found"
     *     )
     * )
     */
    public function show($id)
    {
        $recommendation = Recommendation::find($id);

        if (!$recommendation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recommendation not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $recommendation
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/recommendations/{id}",
     *     summary="Update a recommendation",
     *     description="Updates an existing recommendation",
     *     tags={"Recommendations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the recommendation",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="cpt", type="string"),
     *             @OA\Property(property="description_service", type="string"),
     *             @OA\Property(property="num_units", type="integer"),
     *             @OA\Property(property="breakdown_per_week", type="string"),
     *             @OA\Property(property="location", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recommendation updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recommendation not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $recommendation = Recommendation::find($id);

        if (!$recommendation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recommendation not found'
            ], 404);
        }

        $validated = $request->validate([
            'bip_id' => 'sometimes|required|exists:bips,id',
            'cpt' => 'sometimes|required|string',
            'description_service' => 'sometimes|required|string',
            'num_units' => 'sometimes|required|integer',
            'breakdown_per_week' => 'sometimes|required|string',
            'location' => 'sometimes|required|string',
        ]);

        $recommendation->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Recommendation updated successfully',
            'data' => $recommendation
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/recommendations/{id}",
     *     summary="Delete a recommendation",
     *     description="Deletes an existing recommendation",
     *     tags={"Recommendations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the recommendation",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recommendation deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recommendation not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $recommendation = Recommendation::find($id);

        if (!$recommendation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recommendation not found'
            ], 404);
        }

        $recommendation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recommendation deleted successfully'
        ]);
    }
}
