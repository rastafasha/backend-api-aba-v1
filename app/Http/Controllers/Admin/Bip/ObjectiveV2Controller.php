<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObjectiveV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/objectives",
     *     summary="List all Objectives",
     *     description="Retrieve a paginated list of objectives with optional filters",
     *     tags={"Objectives"},
     *     @OA\Parameter(
     *         name="plan_id",
     *         in="query",
     *         description="Filter objectives by Plan ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Filter objectives by type (STO or LTO)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"STO", "LTO"})
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter objectives by their current status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"in progress", "mastered", "not started", "discontinued", "maintenance"})
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
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
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Objective")),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost/api/v2/objectives?page=1"),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=3),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost/api/v2/objectives?page=3"),
     *                 @OA\Property(property="next_page_url", type="string", example="http://localhost/api/v2/objectives?page=2"),
     *                 @OA\Property(property="path", type="string", example="http://localhost/api/v2/objectives"),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="prev_page_url", type="string", example=null),
     *                 @OA\Property(property="to", type="integer", example=15),
     *                 @OA\Property(property="total", type="integer", example=40)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Invalid parameters")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Objective::query();

        if ($request->has('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $objectives = $query->with('plan')
            ->orderBy('order')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $objectives
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/objectives",
     *     summary="Create a new Objective",
     *     description="Create a new objective. Note: Only one LTO is allowed per plan, and LTOs must have order=999.",
     *     tags={"Objectives"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"plan_id", "type", "description", "target", "initial_date", "end_date"},
     *             @OA\Property(property="plan_id", type="integer", example=1),
     *             @OA\Property(
     *                 property="type",
     *                 type="string",
     *                 enum={"STO", "LTO"},
     *                 example="STO",
     *                 description="LTO = Long Term Objective (only one per plan, order=999), STO = Short Term Objective"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"in progress", "mastered", "not started", "discontinued", "maintenance"},
     *                 example="not started",
     *                 description="Initial status of the objective"
     *             ),
     *             @OA\Property(
     *                 property="initial_date",
     *                 type="string",
     *                 format="date",
     *                 example="2024-01-01",
     *                 description="Start date. Must be before end_date."
     *             ),
     *             @OA\Property(
     *                 property="end_date",
     *                 type="string",
     *                 format="date",
     *                 example="2024-03-01",
     *                 description="End date. Must be after initial_date."
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 example="Reduce inappropriate behavior to less than 5 instances per day"
     *             ),
     *             @OA\Property(
     *                 property="target",
     *                 type="number",
     *                 format="float",
     *                 example=5,
     *                 description="For maladaptive plans: 0-100 (reduction). For replacement plans: >= 0 (improvement)."
     *             ),
     *             @OA\Property(
     *                 property="order",
     *                 type="integer",
     *                 example=1,
     *                 description="Optional for STOs (will be placed at end if not provided). For LTOs, always set to 999."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Objective created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Objective created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Objective")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\AdditionalProperties(
     *                     type="array",
     *                     @OA\Items(type="string")
     *                 ),
     *                 example={
     *                     "type": {"The type field is required."},
     *                     "target": {"Target for maladaptive plans must be between 0 and 100"},
     *                     "multiple_lto": {"Plan already has a long term objective"}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Always set LTO order to 999
        if (isset($data['type']) && $data['type'] === 'LTO') {
            $data['order'] = 999;
        }

        $validator = Objective::validate($data);

        if ($validator->fails()) {
            $errors = $validator->errors();

            // Check for multiple LTO error
            if ($errors->has('multiple_lto')) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errors->first('multiple_lto')
                ], 422);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $errors
            ], 422);
        }

        DB::beginTransaction();
        try {
            // If order is not provided for STO, put it at the end
            if (!isset($data['order'])) {
                $maxOrder = Objective::where('plan_id', $data['plan_id'])
                    ->where('type', 'STO')
                    ->max('order') ?? 0;
                $data['order'] = $maxOrder + 1;
            } elseif ($data['type'] === 'STO') {
                // If order is provided for STO, shift existing objectives
                $this->shiftObjectivesOrder($data['plan_id'], $data['order']);
            }

            $objective = Objective::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Objective created successfully',
                'data' => $objective->load('plan')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating objective'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v2/objectives/{id}",
     *     summary="Get Objective by ID",
     *     description="Retrieve a single objective with its associated plan",
     *     tags={"Objectives"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Objective ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Objective")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Objective not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Objective not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $objective = Objective::with('plan')->find($id);

        if (!$objective) {
            return response()->json([
                'status' => 'error',
                'message' => 'Objective not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $objective
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/objectives/{id}",
     *     summary="Update an Objective",
     *     description="Update an existing objective. Note: LTO order cannot be changed from 999.",
     *     tags={"Objectives"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Objective ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"in progress", "mastered", "not started", "discontinued", "maintenance"}
     *             ),
     *             @OA\Property(property="initial_date", type="string", format="date"),
     *             @OA\Property(property="end_date", type="string", format="date"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(
     *                 property="target",
     *                 type="number",
     *                 description="For maladaptive plans: 0-100 (reduction). For replacement plans: >= 0 (improvement)."
     *             ),
     *             @OA\Property(
     *                 property="order",
     *                 type="integer",
     *                 description="Only for STOs. Existing objectives will be reordered."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objective updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Objective updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Objective")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Objective not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $objective = Objective::find($id);

        if (!$objective) {
            return response()->json([
                'status' => 'error',
                'message' => 'Objective not found'
            ], 404);
        }

        $validator = Objective::validate($request->all());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Handle order changes if necessary
            if ($request->has('order') && $request->order != $objective->order) {
                $this->shiftObjectivesOrder($objective->plan_id, $request->order, $objective->id);
            }

            $objective->update($request->all());
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Objective updated successfully',
                'data' => $objective->fresh()->load('plan')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating objective'
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/objectives/{id}",
     *     summary="Delete an Objective",
     *     description="Delete an objective and reorder remaining objectives if necessary",
     *     tags={"Objectives"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Objective ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objective deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Objective deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Objective not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Objective not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Error deleting objective")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $objective = Objective::find($id);

        if (!$objective) {
            return response()->json([
                'status' => 'error',
                'message' => 'Objective not found'
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Get the current order and plan_id before deleting
            $currentOrder = $objective->order;
            $planId = $objective->plan_id;

            $objective->delete();

            // Reorder remaining objectives
            Objective::where('plan_id', $planId)
                ->where('order', '>', $currentOrder)
                ->decrement('order');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Objective deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting objective'
            ], 500);
        }
    }

    /**
     * Helper method to shift objectives order when inserting or updating
     */
    private function shiftObjectivesOrder($planId, $newOrder, $excludeId = null)
    {
        $query = Objective::where('plan_id', $planId)
            ->where('order', '>=', $newOrder);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $query->increment('order');
    }

    /**
     * @OA\Post(
     *     path="/api/v2/objectives/reorder",
     *     summary="Reorder objectives",
     *     tags={"Objectives"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"objectives"},
     *             @OA\Property(
     *                 property="objectives",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"id", "order"},
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="order", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objectives reordered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Objectives reordered successfully")
     *         )
     *     )
     * )
     */
    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'objectives' => 'required|array',
            'objectives.*.id' => 'required|exists:objectives,id',
            'objectives.*.order' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($request->objectives as $objectiveData) {
                Objective::where('id', $objectiveData['id'])
                    ->update(['order' => $objectiveData['order']]);
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Objectives reordered successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error reordering objectives'
            ], 500);
        }
    }
}
