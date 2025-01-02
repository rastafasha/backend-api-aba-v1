<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\Replacement;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReplacementV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/replacements",
     *     summary="List all replacement behaviors",
     *     tags={"Replacements"},
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
     *         description="Filter by name",
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
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Replacement")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Replacement::with(['longTermObjectives', 'shortTermObjectives']);

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
        $replacements = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $replacements
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/replacements",
     *     summary="Create a new Replacement behavior",
     *     tags={"Replacements"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id", "name", "description", "baseline_level", "baseline_date", "initial_intensity", "current_intensity", "status"},
     *             @OA\Property(property="bip_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Communication Skills"),
     *             @OA\Property(property="description", type="string", example="Uses appropriate communication methods"),
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
     *         description="Replacement behavior created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Replacement behavior created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Replacement")
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
            'long_term_objectives.*.status' => 'required_with:long_term_objectives|in:in progress,mastered,not started,discontinued,maintenance',
            'long_term_objectives.*.description' => 'required_with:long_term_objectives|string',
            'long_term_objectives.*.target' => 'required_with:long_term_objectives|numeric',
            'short_term_objectives' => 'sometimes|array',
            'short_term_objectives.*.status' => 'required_with:short_term_objectives|in:in progress,mastered,not started,discontinued,maintenance',
            'short_term_objectives.*.description' => 'required_with:short_term_objectives|string',
            'short_term_objectives.*.target' => 'required_with:short_term_objectives|numeric'
        ]);

        $replacement = DB::transaction(function () use ($validated) {
            $replacement = Replacement::create($validated);

            // Handle nested creation of long term objectives
            if (isset($validated['long_term_objectives'])) {
                foreach ($validated['long_term_objectives'] as $lto) {
                    $lto['replacement_id'] = $replacement->id;
                    $replacement->longTermObjectives()->create($lto);
                }
            }

            // Handle nested creation of short term objectives
            if (isset($validated['short_term_objectives'])) {
                foreach ($validated['short_term_objectives'] as $index => $sto) {
                    $sto['replacement_id'] = $replacement->id;
                    $sto['order'] = $index + 1;
                    $replacement->shortTermObjectives()->create($sto);
                }
            }

            return $replacement;
        });

        // Load the relationships for the response
        $replacement->load(['longTermObjectives', 'shortTermObjectives']);

        return response()->json([
            'status' => 'success',
            'message' => 'Replacement behavior created successfully',
            'data' => $replacement
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/replacements/{id}",
     *     summary="Get Replacement behavior by ID",
     *     tags={"Replacements"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Replacement behavior ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Replacement")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $replacement = Replacement::with(['longTermObjectives', 'shortTermObjectives'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $replacement
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/replacements/{id}",
     *     summary="Update a Replacement behavior",
     *     tags={"Replacements"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Replacement behavior ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Replacement")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Replacement behavior updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Replacement behavior updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Replacement")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $replacement = Replacement::findOrFail($id);

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

        $replacement->update($validated);

        // Load the relationships for the response
        $replacement->load(['longTermObjectives', 'shortTermObjectives']);

        return response()->json([
            'status' => 'success',
            'message' => 'Replacement behavior updated successfully',
            'data' => $replacement->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/replacements/{id}",
     *     summary="Delete a Replacement behavior",
     *     tags={"Replacements"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Replacement behavior ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Replacement behavior deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Replacement behavior and related objectives deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $replacement = Replacement::findOrFail($id);

        // Use a transaction to ensure all related records are deleted
        DB::transaction(function () use ($replacement) {
            // Delete related objectives
            $replacement->longTermObjectives()->delete();
            $replacement->shortTermObjectives()->delete();
            $replacement->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Replacement behavior and related objectives deleted successfully'
        ]);
    }
}
