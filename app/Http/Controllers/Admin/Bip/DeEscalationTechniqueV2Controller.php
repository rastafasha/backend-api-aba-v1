<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\DeEscalationTechnique;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedDeEscalationTechniqueResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/DeEscalationTechnique")),
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
class DeEscalationTechniqueV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/de-escalation-techniques",
     *     summary="Get paginated de-escalation techniques",
     *     description="Retrieves a paginated list of de-escalation techniques with optional filters",
     *     tags={"Admin/De-escalation Techniques"},
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
     *                 ref="#/components/schemas/PaginatedDeEscalationTechniqueResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = DeEscalationTechnique::query();

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        $perPage = $request->input('per_page', 15);
        $techniques = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $techniques
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/de-escalation-techniques",
     *     summary="Create a new de-escalation technique",
     *     description="Creates a new de-escalation technique with the provided data",
     *     tags={"Admin/De-escalation Techniques"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id"},
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="service_recomendation", type="string"),
     *             @OA\Property(property="recomendation_lists", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="cpt", type="string"),
     *                     @OA\Property(property="location", type="string"),
     *                     @OA\Property(property="num_units", type="integer"),
     *                     @OA\Property(property="breakdown_per_week", type="string"),
     *                     @OA\Property(property="description_service", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="De-escalation technique created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="De-escalation technique created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/DeEscalationTechnique")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = DeEscalationTechnique::validate($request->all());

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $technique = DeEscalationTechnique::create($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'De-escalation technique created successfully',
            'data' => $technique
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/de-escalation-techniques/{id}",
     *     summary="Get a single de-escalation technique",
     *     description="Retrieves a specific de-escalation technique by its ID",
     *     tags={"Admin/De-escalation Techniques"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the de-escalation technique",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/DeEscalationTechnique")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="De-escalation technique not found"
     *     )
     * )
     */
    public function show($id)
    {
        $technique = DeEscalationTechnique::find($id);

        if (!$technique) {
            return response()->json([
                'status' => 'error',
                'message' => 'De-escalation technique not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $technique
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/de-escalation-techniques/{id}",
     *     summary="Update a de-escalation technique",
     *     description="Updates an existing de-escalation technique",
     *     tags={"Admin/De-escalation Techniques"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the de-escalation technique",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="service_recomendation", type="string"),
     *             @OA\Property(property="recomendation_lists", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="cpt", type="string"),
     *                     @OA\Property(property="location", type="string"),
     *                     @OA\Property(property="num_units", type="integer"),
     *                     @OA\Property(property="breakdown_per_week", type="string"),
     *                     @OA\Property(property="description_service", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="De-escalation technique updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="De-escalation technique not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $technique = DeEscalationTechnique::find($id);

        if (!$technique) {
            return response()->json([
                'status' => 'error',
                'message' => 'De-escalation technique not found'
            ], 404);
        }

        $validated = DeEscalationTechnique::validate($request->all());

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $technique->update($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'De-escalation technique updated successfully',
            'data' => $technique
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/de-escalation-techniques/{id}",
     *     summary="Delete a de-escalation technique",
     *     description="Deletes an existing de-escalation technique",
     *     tags={"Admin/De-escalation Techniques"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the de-escalation technique",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="De-escalation technique deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="De-escalation technique not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $technique = DeEscalationTechnique::find($id);

        if (!$technique) {
            return response()->json([
                'status' => 'error',
                'message' => 'De-escalation technique not found'
            ], 404);
        }

        $technique->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'De-escalation technique deleted successfully'
        ]);
    }
}
