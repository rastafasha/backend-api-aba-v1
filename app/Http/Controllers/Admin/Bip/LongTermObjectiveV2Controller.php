<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\LongTermObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LongTermObjectiveV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/long-term-objectives",
     *     summary="Get all Long Term Objectives with filters",
     *     tags={"Long Term Objectives"},
     *     @OA\Parameter(name="reduction_goal_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="status", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="per_page", in="query", required=false, @OA\Schema(type="integer", default=15)),
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(Request $request)
    {
        $query = LongTermObjective::query();

        if ($request->has('reduction_goal_id')) {
            $query->where('reduction_goal_id', $request->reduction_goal_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $objectives = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $objectives
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/long-term-objectives",
     *     summary="Create a new Long Term Objective",
     *     tags={"Long Term Objectives"},
     *     @OA\Response(response=201, description="Objective created successfully")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reduction_goal_id' => 'required|exists:reduction_goals,id',
            'status' => 'required|in:in progress,mastered,initiated,on hold,discontinued,maintenance',
            'initial_date' => 'required|date',
            'end_date' => 'required|date|after:initial_date',
            'description' => 'required|string',
            'target' => 'required|numeric'
        ]);

        // Check if reduction goal already has a long term objective
        $existing = LongTermObjective::where('reduction_goal_id', $validated['reduction_goal_id'])->first();
        if ($existing) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reduction goal already has a long term objective'
            ], 422);
        }

        $objective = LongTermObjective::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Long term objective created successfully',
            'data' => $objective
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/long-term-objectives/{id}",
     *     summary="Get Long Term Objective by ID",
     *     tags={"Long Term Objectives"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function show($id)
    {
        $objective = LongTermObjective::with('reductionGoal')->find($id);

        if (!$objective) {
            return response()->json([
                'status' => 'error',
                'message' => 'Long term objective not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $objective
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/long-term-objectives/{id}",
     *     summary="Update a Long Term Objective",
     *     tags={"Long Term Objectives"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Objective updated successfully")
     * )
     */
    public function update(Request $request, $id)
    {
        $objective = LongTermObjective::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|required|in:in progress,mastered,initiated,on hold,discontinued,maintenance',
            'initial_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:initial_date',
            'description' => 'sometimes|required|string',
            'target' => 'sometimes|required|numeric'
        ]);

        $objective->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Long term objective updated successfully',
            'data' => $objective->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/long-term-objectives/{id}",
     *     summary="Delete a Long Term Objective",
     *     tags={"Long Term Objectives"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Objective deleted successfully")
     * )
     */
    public function destroy($id)
    {
        $objective = LongTermObjective::find($id);

        if (!$objective) {
            return response()->json([
                'status' => 'error',
                'message' => 'Long term objective not found'
            ], 404);
        }

        $objective->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Long term objective deleted successfully'
        ]);
    }
}
