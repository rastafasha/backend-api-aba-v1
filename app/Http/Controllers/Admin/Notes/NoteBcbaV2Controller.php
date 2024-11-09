<?php

namespace App\Http\Controllers\Admin\Notes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Note\NoteBcbaResource;
use App\Models\Notes\NoteBcba;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedNoteBcbaResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/NoteBcba")),
 *     @OA\Property(property="first_page_url", type="string", example="http://example.com/api/v2/notes/bcba?page=1"),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=1),
 *     @OA\Property(property="last_page_url", type="string", example="http://example.com/api/v2/notes/bcba?page=1"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string", example="http://example.com/api/v2/notes/bcba"),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer", example=15),
 *     @OA\Property(property="total", type="integer", example=100)
 * )
 */
class NoteBcbaV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/notes/bcba",
     *     summary="Get paginated BCBA notes",
     *     description="Retrieves a paginated list of BCBA notes with optional filters",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="query",
     *         description="Filter by patient ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="bip_id",
     *         in="query",
     *         description="Filter by BIP ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="location_id",
     *         in="query",
     *         description="Filter by location ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="date_start",
     *         in="query",
     *         description="Start date for filtering (Y-m-d)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="date_end",
     *         in="query",
     *         description="End date for filtering (Y-m-d)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
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
     *                 ref="#/components/schemas/PaginatedNoteBcbaResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = NoteBcba::query();

        // Filter by patient_id
        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by bip_id
        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        // Filter by location_id
        if ($request->has('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Filter by date range
        if ($request->has('date_start') && $request->has('date_end')) {
            $query->whereBetween('session_date', [
                $request->date_start,
                $request->date_end
            ]);
        }

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $notes = $query->orderBy('created_at', 'desc')
            ->with(['patient', 'bips', 'location', 'rendering', 'tecnico', 'supervisor'])
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => NoteBcbaResource::collection($notes)
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/notes/bcba/{id}",
     *     summary="Get a single BCBA note",
     *     description="Retrieves a specific BCBA note by its ID",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the BCBA note",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/NoteBcba"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
     *     )
     * )
     */
    public function show($id)
    {
        $note = NoteBcba::with(['patient', 'bips', 'location', 'rendering', 'tecnico', 'supervisor'])
            ->find($id);

        if (!$note) {
            return response()->json([
                'status' => 'error',
                'message' => 'Note not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => NoteBcbaResource::make($note)
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/notes/bcba/{id}",
     *     summary="Update a BCBA note",
     *     description="Updates an existing BCBA note",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the BCBA note",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"session_date", "patient_id"},
     *             @OA\Property(property="session_date", type="string", format="date"),
     *             @OA\Property(property="patient_id", type="integer"),
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="location_id", type="integer"),
     *             @OA\Property(property="summary_note", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $note = NoteBcba::find($id);

        if (!$note) {
            return response()->json([
                'status' => 'error',
                'message' => 'Note not found'
            ], 404);
        }

        $validated = $request->validate([
            'session_date' => 'required|date',
            'patient_id' => 'required|exists:patients,id',
            'bip_id' => 'nullable|exists:bips,id',
            'location_id' => 'nullable|exists:locations,id',
            'summary_note' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $note->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Note updated successfully',
            'data' => NoteBcbaResource::make($note->fresh(['patient', 'bips', 'location', 'rendering', 'tecnico', 'supervisor']))
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/notes/bcba/{id}",
     *     summary="Delete a BCBA note",
     *     description="Deletes an existing BCBA note",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the BCBA note",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $note = NoteBcba::find($id);

        if (!$note) {
            return response()->json([
                'status' => 'error',
                'message' => 'Note not found'
            ], 404);
        }

        $note->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Note deleted successfully'
        ]);
    }
}