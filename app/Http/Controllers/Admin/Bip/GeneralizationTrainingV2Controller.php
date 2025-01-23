<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\GeneralizationTraining;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedGeneralizationTrainingResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/GeneralizationTraining")),
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
class GeneralizationTrainingV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/generalization-trainings",
     *     summary="Get paginated generalization trainings",
     *     description="Retrieves a paginated list of generalization trainings with optional filters",
     *     tags={"Admin/Generalization Trainings"},
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
     *                 ref="#/components/schemas/PaginatedGeneralizationTrainingResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = GeneralizationTraining::query();

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        $perPage = $request->input('per_page', 15);
        $trainings = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $trainings
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/generalization-trainings",
     *     summary="Create a new generalization training",
     *     description="Creates a new generalization training with the provided data",
     *     tags={"Admin/Generalization Trainings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id"},
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="discharge_plan", type="string"),
     *             @OA\Property(property="transition_fading_plans", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="transition_plan", type="string"),
     *                     @OA\Property(property="fading_plan", type="string"),
     *                     @OA\Property(property="timeline", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Generalization training created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Generalization training created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/GeneralizationTraining")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = GeneralizationTraining::validate($request->all());

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $training = GeneralizationTraining::create($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Generalization training created successfully',
            'data' => $training
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/generalization-trainings/{id}",
     *     summary="Get a single generalization training",
     *     description="Retrieves a specific generalization training by its ID",
     *     tags={"Admin/Generalization Trainings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the generalization training",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/GeneralizationTraining")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Generalization training not found"
     *     )
     * )
     */
    public function show($id)
    {
        $training = GeneralizationTraining::find($id);

        if (!$training) {
            return response()->json([
                'status' => 'error',
                'message' => 'Generalization training not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $training
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/generalization-trainings/{id}",
     *     summary="Update a generalization training",
     *     description="Updates an existing generalization training",
     *     tags={"Admin/Generalization Trainings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the generalization training",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="discharge_plan", type="string"),
     *             @OA\Property(property="transition_fading_plans", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="transition_plan", type="string"),
     *                     @OA\Property(property="fading_plan", type="string"),
     *                     @OA\Property(property="timeline", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Generalization training updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Generalization training not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $training = GeneralizationTraining::find($id);

        if (!$training) {
            return response()->json([
                'status' => 'error',
                'message' => 'Generalization training not found'
            ], 404);
        }

        $validated = GeneralizationTraining::validate($request->all());

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $training->update($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Generalization training updated successfully',
            'data' => $training
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/generalization-trainings/{id}",
     *     summary="Delete a generalization training",
     *     description="Deletes an existing generalization training",
     *     tags={"Admin/Generalization Trainings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the generalization training",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Generalization training deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Generalization training not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $training = GeneralizationTraining::find($id);

        if (!$training) {
            return response()->json([
                'status' => 'error',
                'message' => 'Generalization training not found'
            ], 404);
        }

        $training->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Generalization training deleted successfully'
        ]);
    }
}
