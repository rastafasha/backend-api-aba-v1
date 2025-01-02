<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\Maladaptive;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Maladaptives",
 *     description="API Endpoints for managing maladaptive behaviors"
 * )
 */
class MaladaptiveV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/maladaptives",
     *     summary="Get all Maladaptive behaviors with filters",
     *     tags={"Maladaptives"},
     *     @OA\Parameter(
     *         name="bip_id",
     *         in="query",
     *         description="Filter by BIP ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by behavior name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
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
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/Maladaptive")
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
        $query = Maladaptive::with(['longTermObjectives', 'shortTermObjectives']);

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $maladaptives = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $maladaptives
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/maladaptives",
     *     summary="Create a new Maladaptive behavior",
     *     tags={"Maladaptives"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id", "name", "description", "baseline_level", "baseline_date", "initial_intensity", "current_intensity", "status"},
     *             @OA\Property(property="bip_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Aggressive Behavior"),
     *             @OA\Property(property="description", type="string", example="Displays aggressive behavior towards others"),
     *             @OA\Property(property="baseline_level", type="integer", example=5),
     *             @OA\Property(property="baseline_date", type="string", format="date-time"),
     *             @OA\Property(property="initial_intensity", type="integer", example=7),
     *             @OA\Property(property="current_intensity", type="integer", example=4),
     *             @OA\Property(property="status", type="string", enum={"active", "completed", "hold", "discontinued", "maintenance", "met", "monitoring"}),
     *             @OA\Property(
     *                 property="long_term_objectives",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/LongTermObjective")
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
     *         description="Maladaptive behavior created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Maladaptive behavior created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Maladaptive")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bip_id' => 'required|exists:bips,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'baseline_level' => 'required|integer',
            'baseline_date' => 'required|date',
            'initial_intensity' => 'required|integer',
            'current_intensity' => 'required|integer',
            'status' => 'required|in:active,completed,hold,discontinued,maintenance,met,monitoring',
            'long_term_objectives' => 'sometimes|array',
            'short_term_objectives' => 'sometimes|array'
        ]);

        $maladaptive = DB::transaction(function () use ($validated) {
            $maladaptive = Maladaptive::create($validated);

            // Handle nested creation of long term objectives
            if (isset($validated['long_term_objectives'])) {
                foreach ($validated['long_term_objectives'] as $lto) {
                    $lto['maladaptive_id'] = $maladaptive->id;
                    $maladaptive->longTermObjectives()->create($lto);
                }
            }

            // Handle nested creation of short term objectives
            if (isset($validated['short_term_objectives'])) {
                foreach ($validated['short_term_objectives'] as $index => $sto) {
                    $sto['maladaptive_id'] = $maladaptive->id;
                    $sto['order'] = $index + 1;
                    $maladaptive->shortTermObjectives()->create($sto);
                }
            }

            return $maladaptive;
        });

        // Load the relationships for the response
        $maladaptive->load(['longTermObjectives', 'shortTermObjectives']);

        return response()->json([
            'status' => 'success',
            'message' => 'Maladaptive behavior created successfully',
            'data' => $maladaptive
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/maladaptives/{id}",
     *     summary="Get Maladaptive behavior by ID",
     *     tags={"Maladaptives"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Maladaptive behavior ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Maladaptive")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $maladaptive = Maladaptive::with(['longTermObjectives', 'shortTermObjectives'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $maladaptive
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/maladaptives/{id}",
     *     summary="Update a Maladaptive behavior",
     *     tags={"Maladaptives"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Maladaptive behavior ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Maladaptive")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Maladaptive behavior updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Maladaptive behavior updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Maladaptive")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $maladaptive = Maladaptive::findOrFail($id);

        $validated = $request->validate([
            'bip_id' => 'sometimes|required|exists:bips,id',
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'baseline_level' => 'sometimes|required|integer',
            'baseline_date' => 'sometimes|required|date',
            'initial_intensity' => 'sometimes|required|integer',
            'current_intensity' => 'sometimes|required|integer',
            'status' => 'sometimes|required|in:active,completed,hold,discontinued,maintenance,met,monitoring'
        ]);

        $maladaptive->update($validated);

        // Load the relationships for the response
        $maladaptive->load(['longTermObjectives', 'shortTermObjectives']);

        return response()->json([
            'status' => 'success',
            'message' => 'Maladaptive behavior updated successfully',
            'data' => $maladaptive->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/maladaptives/{id}",
     *     summary="Delete a Maladaptive behavior",
     *     tags={"Maladaptives"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Maladaptive behavior ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Maladaptive behavior deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Maladaptive behavior and related objectives deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $maladaptive = Maladaptive::findOrFail($id);

        // Use a transaction to ensure all related records are deleted
        DB::transaction(function () use ($maladaptive) {
            // Delete related objectives
            $maladaptive->longTermObjectives()->delete();
            $maladaptive->shortTermObjectives()->delete();
            $maladaptive->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Maladaptive behavior and related objectives deleted successfully'
        ]);
    }
}
