<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\ReductionGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Reduction Goals",
 *     description="API Endpoints for managing reduction goals"
 * )
 */
class ReductionGoalV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/reduction-goals",
     *     summary="Get all Reduction Goals with filters",
     *     tags={"Reduction Goals"},
     *     @OA\Parameter(
     *         name="bip_id",
     *         in="query",
     *         description="Filter by BIP ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="patient_identifier",
     *         in="query",
     *         description="Filter by patient identifier",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="client_id",
     *         in="query",
     *         description="Filter by client ID",
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
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ReductionGoal")
     *                 ),
     *                 @OA\Property(property="total", type="integer", example=50),
     *                 @OA\Property(property="per_page", type="integer", example=15)
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = ReductionGoal::with(['longTermObjective', 'shortTermObjectives', 'bip']);

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        if ($request->has('patient_identifier')) {
            $query->where('patient_identifier', $request->patient_identifier);
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $perPage = $request->input('per_page', 15);
        $goals = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $goals
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/reduction-goals",
     *     summary="Create a new Reduction Goal",
     *     tags={"Reduction Goals"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id", "patient_identifier", "client_id", "current_status", "maladaptive"},
     *             @OA\Property(property="bip_id", type="integer", example=1),
     *             @OA\Property(property="patient_identifier", type="string", example="PAT001"),
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(
     *                 property="current_status",
     *                 type="string",
     *                 enum={"active", "completed", "on hold", "discontinued"},
     *                 example="active"
     *             ),
     *             @OA\Property(property="maladaptive", type="string", example="Inappropriate Language"),
     *             @OA\Property(
     *                 property="long_term_objective",
     *                 type="object",
     *                 ref="#/components/schemas/LongTermObjective"
     *             ),
     *             @OA\Property(
     *                 property="short_term_objectives",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ShortTermObjective")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Goal created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Reduction goal created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ReductionGoal")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\AdditionalProperties(
     *                     type="array",
     *                     @OA\Items(type="string")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bip_id' => 'required|exists:bips,id',
            'patient_identifier' => 'required|string',
            'client_id' => 'required|integer',
            'current_status' => 'required|string',
            'maladaptive' => 'required|string',
            // Optional nested creation of objectives
            'long_term_objective' => 'sometimes|array',
            'short_term_objectives' => 'sometimes|array'
        ]);

        // Create the reduction goal
        $goal = ReductionGoal::create([
            'bip_id' => $validated['bip_id'],
            'patient_identifier' => $validated['patient_identifier'],
            'client_id' => $validated['client_id'],
            'current_status' => $validated['current_status'],
            'maladaptive' => $validated['maladaptive']
        ]);

        // Handle nested creation of long term objective
        if (isset($validated['long_term_objective'])) {
            $goal->longTermObjective()->create($validated['long_term_objective']);
        }

        // Handle nested creation of short term objectives
        if (isset($validated['short_term_objectives'])) {
            foreach ($validated['short_term_objectives'] as $index => $sto) {
                $sto['order'] = $index + 1;
                $goal->shortTermObjectives()->create($sto);
            }
        }

        // Load the relationships for the response
        $goal->load(['longTermObjective', 'shortTermObjectives']);

        return response()->json([
            'status' => 'success',
            'message' => 'Reduction goal created successfully',
            'data' => $goal
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/reduction-goals/{id}",
     *     summary="Get Reduction Goal by ID",
     *     tags={"Reduction Goals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Reduction Goal ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/ReductionGoal")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Goal not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Reduction goal not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $goal = ReductionGoal::with(['longTermObjective', 'shortTermObjectives', 'bip'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $goal
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/reduction-goals/{id}",
     *     summary="Update a Reduction Goal",
     *     tags={"Reduction Goals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Reduction Goal ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="bip_id", type="integer", example=1),
     *             @OA\Property(property="patient_identifier", type="string", example="PAT001"),
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(
     *                 property="current_status",
     *                 type="string",
     *                 enum={"active", "completed", "on hold", "discontinued"},
     *                 example="active"
     *             ),
     *             @OA\Property(property="maladaptive", type="string", example="Inappropriate Language")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Goal updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Reduction goal updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ReductionGoal")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Goal not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $goal = ReductionGoal::findOrFail($id);

        $validated = $request->validate([
            'bip_id' => 'sometimes|required|exists:bips,id',
            'patient_identifier' => 'sometimes|required|string',
            'client_id' => 'sometimes|required|integer',
            'current_status' => 'sometimes|required|string',
            'maladaptive' => 'sometimes|required|string'
        ]);

        $goal->update($validated);

        // Load the relationships for the response
        $goal->load(['longTermObjective', 'shortTermObjectives']);

        return response()->json([
            'status' => 'success',
            'message' => 'Reduction goal updated successfully',
            'data' => $goal->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/reduction-goals/{id}",
     *     summary="Delete a Reduction Goal",
     *     tags={"Reduction Goals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Reduction Goal ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Goal deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Reduction goal deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Goal not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Reduction goal not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $goal = ReductionGoal::findOrFail($id);

        // Use a transaction to ensure all related records are deleted
        DB::transaction(function () use ($goal) {
            // Delete related objectives (this will trigger soft deletes)
            $goal->longTermObjective()->delete();
            $goal->shortTermObjectives()->delete();
            $goal->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Reduction goal and related objectives deleted successfully'
        ]);
    }
}
