<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\Plan;
use App\Models\Bip\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/plans",
     *     summary="List all Plans",
     *     description="Retrieve a paginated list of plans with optional filters",
     *     tags={"Plans"},
     *     @OA\Parameter(
     *         name="bip_id",
     *         in="query",
     *         description="Filter plans by BIP ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter plans by name (partial match)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter plans by category",
     *         required=false,
     *         @OA\Schema(type="string", enum={"maladaptive", "replacement", "caregiver_training", "rbt_training"})
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter plans by status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"active", "completed", "hold", "discontinued", "maintenance", "met", "monitoring"})
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
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Plan")),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost/api/v2/plans?page=1"),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=3),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost/api/v2/plans?page=3"),
     *                 @OA\Property(property="next_page_url", type="string", example="http://localhost/api/v2/plans?page=2"),
     *                 @OA\Property(property="path", type="string", example="http://localhost/api/v2/plans"),
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
        $query = Plan::with(['objectives' => function ($q) {
            $q->orderBy('order');
        }]);

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $plans = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $plans
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/plans",
     *     summary="Create a new Plan",
     *     description="Create a new plan with optional objectives. For maladaptive and replacement plans, baseline fields are required.",
     *     tags={"Plans"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id", "name", "description", "category", "status"},
     *             @OA\Property(property="bip_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Aggressive Behavior"),
     *             @OA\Property(property="description", type="string", example="Displays aggressive behavior towards others"),
     *             @OA\Property(property="category", type="string", enum={"maladaptive", "replacement", "caregiver_training", "rbt_training"}),
     *             @OA\Property(property="status", type="string", enum={"active", "completed", "hold", "discontinued", "maintenance", "met", "monitoring"}),
     *             @OA\Property(property="baseline_level", type="integer", example=5, description="Required for maladaptive/replacement"),
     *             @OA\Property(property="baseline_date", type="string", format="date", example="2024-01-01", description="Required for maladaptive/replacement"),
     *             @OA\Property(property="initial_intensity", type="integer", example=7, description="Required for maladaptive/replacement"),
     *             @OA\Property(property="current_intensity", type="integer", example=4, description="Required for maladaptive/replacement"),
     *             @OA\Property(
     *                 property="objectives",
     *                 type="array",
     *                 description="Optional objectives to create with the plan",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"type", "description", "target", "initial_date", "end_date"},
     *                     @OA\Property(property="type", type="string", enum={"LTO", "STO"}),
     *                     @OA\Property(property="description", type="string"),
     *                     @OA\Property(property="target", type="integer"),
     *                     @OA\Property(property="initial_date", type="string", format="date"),
     *                     @OA\Property(property="end_date", type="string", format="date"),
     *                     @OA\Property(property="order", type="integer", description="Optional. For LTOs, will be set to 999")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Plan created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Plan created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Plan")
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
     *                 @OA\Property(property="field", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Plan::validate($request->all(), false);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $plan = Plan::create($request->all());

            // Create objectives if provided
            if ($request->has('objectives')) {
                foreach ($request->objectives as $objectiveData) {
                    $objectiveData['plan_id'] = $plan->id;
                    $objective = Objective::create($objectiveData);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Plan created successfully',
                'data' => $plan->load('objectives')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v2/plans/{id}",
     *     summary="Get Plan by ID",
     *     description="Retrieve a single plan with its objectives",
     *     tags={"Plans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Plan ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Plan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plan not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Plan not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $plan = Plan::with(['objectives' => function ($q) {
            $q->orderBy('order');
        }])->find($id);

        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Plan not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $plan
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/plans/{id}",
     *     summary="Update a Plan",
     *     description="Update an existing plan. Only provided fields will be updated.",
     *     tags={"Plans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Plan ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="category", type="string", enum={"maladaptive", "replacement", "caregiver_training", "rbt_training"}),
     *             @OA\Property(property="status", type="string", enum={"active", "completed", "hold", "discontinued", "maintenance", "met", "monitoring"}),
     *             @OA\Property(property="baseline_level", type="integer"),
     *             @OA\Property(property="baseline_date", type="string", format="date"),
     *             @OA\Property(property="initial_intensity", type="integer"),
     *             @OA\Property(property="current_intensity", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plan updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Plan updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Plan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plan not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Plan not found'
            ], 404);
        }

        // Validate only the fields being updated
        $validator = Plan::validate($request->all(), true);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $plan->update($request->all());
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Plan updated successfully',
                'data' => $plan->fresh()->load('objectives')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating plan'
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/plans/{id}",
     *     summary="Delete a Plan",
     *     description="Delete a plan and all its associated objectives",
     *     tags={"Plans"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Plan ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plan deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Plan and related objectives deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plan not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Plan not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Error deleting plan")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $plan = Plan::with('objectives')->find($id);

        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Plan not found'
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Force delete objectives and plan
            $plan->objectives()->forceDelete();
            $plan->forceDelete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Plan and related objectives deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting plan'
            ], 500);
        }
    }
}
