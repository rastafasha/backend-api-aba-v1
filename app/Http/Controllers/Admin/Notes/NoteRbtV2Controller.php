<?php

namespace App\Http\Controllers\Admin\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notes\NoteRbtRequest;
use App\Models\Notes\NoteRbt;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedNoteRbtResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/NoteRbt")),
 *     @OA\Property(property="first_page_url", type="string", example="http://example.com/api/v2/notes/rbt?page=1"),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=1),
 *     @OA\Property(property="last_page_url", type="string", example="http://example.com/api/v2/notes/rbt?page=1"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string", example="http://example.com/api/v2/notes/rbt"),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer", example=15),
 *     @OA\Property(property="total", type="integer", example=100)
 * )
 */
class NoteRbtV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/notes/rbt",
     *     summary="Get paginated RBT notes",
     *     description="Retrieves a paginated list of RBT notes with optional filters",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="query",
     *         description="Filter by patient ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="doctor_id",
     *         in="query",
     *         description="Filter by doctor ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="provider_id", in="query", description="Filter by provider ID", required=false, @OA\Schema(type="integer")),
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
     *                 ref="#/components/schemas/PaginatedNoteRbtResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = NoteRbt::query();

        // Filter by patient_id
        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by doctor_id
        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter by provider_id
        if ($request->has('provider_id')) {
            $query->where('provider_id', $request->provider_id);
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

        // Get paginated results (15 per page by default)
        $perPage = $request->input('per_page', 15);
        $notes = $query->orderBy('created_at', 'desc')
            ->with(['patient', 'bip', 'location'])
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $notes
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/notes/rbt",
     *     summary="Create a new RBT note",
     *     description="Creates a new RBT note with the provided data",
     *     tags={"Admin/Notes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"session_date", "patient_id", "doctor_id"},
     *             @OA\Property(property="session_date", type="string", format="date-time", example="2023-12-01T00:00:00Z"),
     *             @OA\Property(property="patient_id", type="string"),
     *             @OA\Property(property="doctor_id", type="integer"),
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="pos", type="string"),
     *             @OA\Property(property="time_in", type="string", format="time", example="09:00:00"),
     *             @OA\Property(property="time_out", type="string", format="time", example="10:00:00"),
     *             @OA\Property(property="time_in2", type="string", format="time", example="14:00:00"),
     *             @OA\Property(property="time_out2", type="string", format="time", example="15:00:00"),
     *             @OA\Property(property="environmental_changes", type="string"),
     *             @OA\Property(property="maladaptives", type="object"),
     *             @OA\Property(property="replacements", type="object"),
     *             @OA\Property(property="interventions", type="object"),
     *             @OA\Property(property="meet_with_client_at", type="string"),
     *             @OA\Property(property="client_appeared", type="string"),
     *             @OA\Property(property="as_evidenced_by", type="string"),
     *             @OA\Property(property="rbt_modeled_and_demonstrated_to_caregiver", type="string"),
     *             @OA\Property(property="client_response_to_treatment_this_session", type="string"),
     *             @OA\Property(property="progress_noted_this_session_compared_to_previous_session", type="string"),
     *             @OA\Property(property="next_session_is_scheduled_for", type="string", format="date-time"),
     *             @OA\Property(property="provider_id", type="integer"),
     *             @OA\Property(property="provider_signature", type="string"),
     *             @OA\Property(property="provider_credential", type="string"),
     *             @OA\Property(property="supervisor_signature", type="string"),
     *             @OA\Property(property="supervisor_name", type="integer"),
     *             @OA\Property(property="billed", type="boolean"),
     *             @OA\Property(property="pay", type="boolean"),
     *             @OA\Property(property="md", type="string"),
     *             @OA\Property(property="md2", type="string"),
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
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Note created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/NoteRbt")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(NoteRbtRequest $request)
    {
        $note = NoteRbt::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Note created successfully',
            'data' => $note,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/notes/rbt/{id}",
     *     summary="Get a single RBT note",
     *     description="Retrieves a specific RBT note by its ID",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the RBT note",
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
     *                 ref="#/components/schemas/NoteRbt"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Note not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $note = NoteRbt::with(['patient', 'bip', 'location'])
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
     *     path="/api/v2/notes/rbt/{id}",
     *     summary="Update an RBT note",
     *     description="Updates an existing RBT note",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the RBT note",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"session_date", "patient_id", "doctor_id"},
     *             @OA\Property(property="session_date", type="string", format="date-time", example="2023-12-01T00:00:00Z"),
     *             @OA\Property(property="patient_id", type="string"),
     *             @OA\Property(property="doctor_id", type="integer"),
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="pos", type="string"),
     *             @OA\Property(property="time_in", type="string", format="time", example="09:00:00"),
     *             @OA\Property(property="time_out", type="string", format="time", example="10:00:00"),
     *             @OA\Property(property="time_in2", type="string", format="time", example="14:00:00"),
     *             @OA\Property(property="time_out2", type="string", format="time", example="15:00:00"),
     *             @OA\Property(property="environmental_changes", type="string"),
     *             @OA\Property(property="maladaptives", type="object"),
     *             @OA\Property(property="replacements", type="object"),
     *             @OA\Property(property="interventions", type="object"),
     *             @OA\Property(property="meet_with_client_at", type="string"),
     *             @OA\Property(property="client_appeared", type="string"),
     *             @OA\Property(property="as_evidenced_by", type="string"),
     *             @OA\Property(property="rbt_modeled_and_demonstrated_to_caregiver", type="string"),
     *             @OA\Property(property="client_response_to_treatment_this_session", type="string"),
     *             @OA\Property(property="progress_noted_this_session_compared_to_previous_session", type="string"),
     *             @OA\Property(property="next_session_is_scheduled_for", type="string", format="date-time"),
     *             @OA\Property(property="provider_id", type="integer"),
     *             @OA\Property(property="provider_signature", type="string"),
     *             @OA\Property(property="provider_credential", type="string"),
     *             @OA\Property(property="supervisor_signature", type="string"),
     *             @OA\Property(property="supervisor_name", type="integer"),
     *             @OA\Property(property="billed", type="boolean"),
     *             @OA\Property(property="pay", type="boolean"),
     *             @OA\Property(property="md", type="string"),
     *             @OA\Property(property="md2", type="string"),
     *             @OA\Property(property="cpt_code", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "ok", "no", "review"}),
     *             @OA\Property(property="location_id", type="integer"),
     *             @OA\Property(property="pa_service_id", type="integer"),
     *             @OA\Property(property="insuranceId", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Note updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/NoteRbt")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(NoteRbtRequest $request, $id)
    {
        $note = NoteRbt::findOrFail($id);

        $note->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Note updated successfully',
            'data' => $note,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/notes/rbt/{id}",
     *     summary="Delete an RBT note",
     *     description="Deletes an existing RBT note",
     *     tags={"Admin/Notes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the RBT note",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Note deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Note not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $note = NoteRbt::find($id);

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
