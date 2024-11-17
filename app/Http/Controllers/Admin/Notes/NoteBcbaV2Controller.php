<?php

namespace App\Http\Controllers\Admin\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notes\NoteBcbaRequest;
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

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $notes = $query->filterByDateRange($request->date_start, $request->date_end)
            ->orderBy('created_at', 'desc')
            ->with(['patient', 'bip', 'location'])
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $notes
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/notes/bcba",
     *     summary="Create a new BCBA note",
     *     description="Creates a new BCBA note with the provided data",
     *     tags={"Admin/Notes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"patient_id", "session_date"},
     *             @OA\Property(property="insurance_id", type="integer"),
     *             @OA\Property(property="patient_id", type="string"),
     *             @OA\Property(property="doctor_id", type="integer"),
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="diagnosis_code", type="string", maxLength=50),
     *             @OA\Property(property="location", type="string", maxLength=50),
     *             @OA\Property(property="summary_note", type="string"),
     *             @OA\Property(property="note_description", type="string"),
     *             @OA\Property(property="session_date", type="string", format="date"),
     *             @OA\Property(property="time_in", type="string", format="H:i:s"),
     *             @OA\Property(property="time_out", type="string", format="H:i:s"),
     *             @OA\Property(property="time_in2", type="string", format="H:i:s"),
     *             @OA\Property(property="time_out2", type="string", format="H:i:s"),
     *             @OA\Property(property="session_length_total", type="number", format="double"),
     *             @OA\Property(property="supervisor_id", type="integer"),
     *             @OA\Property(property="caregiver_goals", type="object"),
     *             @OA\Property(property="rbt_training_goals", type="object"),
     *             @OA\Property(property="provider_signature", type="string"),
     *             @OA\Property(property="provider_id", type="integer"),
     *             @OA\Property(property="supervisor_signature", type="string"),
     *             @OA\Property(property="meet_with_client_at", type="string"),
     *             @OA\Property(property="billed", type="boolean"),
     *             @OA\Property(property="paid", type="boolean"),
     *             @OA\Property(property="cpt_code", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "ok", "no", "review"}),
     *             @OA\Property(property="location_id", type="integer"),
     *             @OA\Property(property="pa_service_id", type="integer"),
     *             @OA\Property(property="insuranceId", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Note created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Note created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/NoteBcba")
     *         )
     *     )
     * )
     */
    public function store(NoteBcbaRequest $request)
    {
        $note = NoteBcba::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Note created successfully',
            'data' => $note,
        ], 201);
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
        $note = NoteBcba::with(['patient', 'bip', 'location',])
            ->find($id);

        if (!$note) {
            return response()->json([
                'status' => 'error',
                'message' => 'Note not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $note
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
    public function update(NoteBcbaRequest $request, $id)
    {
        $note = NoteBcba::findOrFail($id);

        $note->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Note updated successfully',
            'data' => $note,
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
