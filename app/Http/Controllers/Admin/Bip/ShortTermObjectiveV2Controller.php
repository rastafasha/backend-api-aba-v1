<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ShortTermObjectiveV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/short-term-objectives",
     *     summary="Get all Short Term Objectives with filters",
     *     tags={"Short Term Objectives"},
     *     @OA\Parameter(name="maladaptive_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="status", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="per_page", in="query", required=false, @OA\Schema(type="integer", default=15)),
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(Request $request)
    {
        $query = ShortTermObjective::query();

        if ($request->has('maladaptive_id')) {
            $query->where('maladaptive_id', $request->maladaptive_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $objectives = $query->orderBy('order')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $objectives
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/short-term-objectives",
     *     summary="Create a new Short Term Objective",
     *     tags={"Short Term Objectives"},
     *     @OA\Response(response=201, description="Objective created successfully")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'maladaptive_id' => 'required|exists:maladaptives,id',
            'status' => 'required|in:in progress,mastered,not started,discontinued,maintenance',
            'initial_date' => 'required|date',
            'end_date' => 'required|date|after:initial_date',
            'description' => 'required|string',
            'target' => 'required|numeric',
            'order' => 'sometimes|integer|min:1'
        ]);

        return DB::transaction(function () use ($validated) {
            // Get all existing objectives for this maladaptive behavior
            $existingObjectives = ShortTermObjective::where('maladaptive_id', $validated['maladaptive_id'])
                ->whereNull('deleted_at')
                ->orderBy('order')
                ->get();

            // If no order is provided, append to the end
            if (!isset($validated['order'])) {
                $validated['order'] = $existingObjectives->count() + 1;
            } else {
                // If order is provided, make space for the new objective
                foreach ($existingObjectives as $obj) {
                    if ($obj->order >= $validated['order']) {
                        $obj->increment('order');
                    }
                }
            }

            $objective = ShortTermObjective::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Short term objective created successfully',
                'data' => $objective->fresh()
            ], 201);
        });
    }

    /**
     * @OA\Get(
     *     path="/api/v2/short-term-objectives/{id}",
     *     summary="Get Short Term Objective by ID",
     *     tags={"Short Term Objectives"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function show($id)
    {
        $objective = ShortTermObjective::with('maladaptive')->find($id);

        if (!$objective) {
            return response()->json([
                'status' => 'error',
                'message' => 'Short term objective not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $objective
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/short-term-objectives/{id}",
     *     summary="Update a Short Term Objective",
     *     tags={"Short Term Objectives"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Objective updated successfully")
     * )
     */
    public function update(Request $request, $id)
    {
        $objective = ShortTermObjective::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|required|in:in progress,mastered,not started,discontinued,maintenance',
            'initial_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:initial_date',
            'description' => 'sometimes|required|string',
            'target' => 'sometimes|required|numeric',
            'order' => 'sometimes|required|integer|min:1'
        ]);

        // Handle order changes if provided
        if (isset($validated['order']) && $validated['order'] !== $objective->order) {
            $oldOrder = $objective->order;
            $newOrder = $validated['order'];

            if ($newOrder > $oldOrder) {
                // Moving down: decrement orders in between
                ShortTermObjective::where('maladaptive_id', $objective->maladaptive_id)
                    ->where('order', '>', $oldOrder)
                    ->where('order', '<=', $newOrder)
                    ->decrement('order');
            } else {
                // Moving up: increment orders in between
                ShortTermObjective::where('maladaptive_id', $objective->maladaptive_id)
                    ->where('order', '<', $oldOrder)
                    ->where('order', '>=', $newOrder)
                    ->increment('order');
            }
        }

        $objective->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Short term objective updated successfully',
            'data' => $objective->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/short-term-objectives/{id}",
     *     summary="Delete a Short Term Objective",
     *     tags={"Short Term Objectives"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Objective deleted successfully")
     * )
     */
    public function destroy($id)
    {
        $objective = ShortTermObjective::findOrFail($id);

        return DB::transaction(function () use ($objective) {
            $currentOrder = $objective->order;
            $maladaptiveId = $objective->maladaptive_id;

            // Get all objectives that need reordering
            $objectivesToReorder = ShortTermObjective::where('maladaptive_id', $maladaptiveId)
                ->whereNull('deleted_at')
                ->where('order', '>', $currentOrder)
                ->orderBy('order')
                ->get();

            // Delete the objective first
            $objective->delete();

            // Update orders sequentially
            foreach ($objectivesToReorder as $index => $obj) {
                ShortTermObjective::where('id', $obj->id)
                    ->update(['order' => $currentOrder + $index]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Short term objective deleted successfully'
            ]);
        });
    }

    /**
     * @OA\Post(
     *     path="/api/v2/short-term-objectives/reorder",
     *     summary="Reorder Short Term Objectives",
     *     description="Update the order of multiple short term objectives at once. All objectives must belong to the same maladaptive behavior.",
     *     tags={"Short Term Objectives"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Array of objectives with their new order positions",
     *         @OA\JsonContent(
     *             required={"objectives"},
     *             @OA\Property(
     *                 property="objectives",
     *                 type="array",
     *                 description="List of objectives to reorder. All objectives should belong to the same maladaptive behavior.",
     *                 example={
     *                     {"id": 1, "order": 3},
     *                     {"id": 2, "order": 1},
     *                     {"id": 3, "order": 2}
     *                 },
     *                 @OA\Items(
     *                     type="object",
     *                     required={"id", "order"},
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         description="The ID of the short term objective"
     *                     ),
     *                     @OA\Property(
     *                         property="order",
     *                         type="integer",
     *                         description="The new position in the order sequence (starting from 1)"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objectives reordered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Short term objectives reordered successfully")
     *         )
     *     )
     * )
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'objectives' => 'required|array',
            'objectives.*.id' => 'required|exists:short_term_objectives,id',
            'objectives.*.order' => 'required|integer|min:1'
        ]);

        return DB::transaction(function () use ($validated) {
            $objectives = ShortTermObjective::whereIn('id', array_column($validated['objectives'], 'id'))->get();

            // Verify all objectives belong to the same maladaptive behavior
            $maladaptiveId = $objectives->first()->maladaptive_id;
            if ($objectives->pluck('maladaptive_id')->unique()->count() > 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'All objectives must belong to the same maladaptive behavior'
                ], 422);
            }

            // Update orders
            foreach ($validated['objectives'] as $update) {
                ShortTermObjective::where('id', $update['id'])->update(['order' => $update['order']]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Short term objectives reordered successfully'
            ]);
        });
    }
}
