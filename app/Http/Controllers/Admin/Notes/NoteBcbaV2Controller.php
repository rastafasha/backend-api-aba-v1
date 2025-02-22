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
     *         name="include",
     *         in="query",
     *         description="Include related models (comma-separated). Options: patient, bip, location, provider, supervisor, doctor",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="query",
     *         description="Filter by patient ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="patient_identifier",
     *         in="query",
     *         description="Filter by patient identifier",
     *         required=false,
     *         @OA\Schema(type="string")
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

        // Filter by patient_identifier
        if ($request->has('patient_identifier')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('patient_identifier', $request->patient_identifier);
            });
        }

        // Filter by bip_id
        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        // Filter by location_id
        if ($request->has('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Handle includes
        $allowedIncludes = ['patient', 'bip', 'location', 'provider', 'supervisor', 'doctor'];
        $includes = [];
        if ($request->has('include')) {
            $includes = array_filter(
                explode(',', $request->input('include')),
                fn($include) => in_array(trim($include), $allowedIncludes)
            );
        }

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $notes = $query->filterBySessionDateRange($request->date_start, $request->date_end)
            ->orderBy('created_at', 'desc')
            ->with($includes)
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
     *             @OA\Property(property="patient_id", type="integer"),
     *             @OA\Property(property="patient_identifier", type="string", maxLength=50),
     *             @OA\Property(property="doctor_id", type="integer"),
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="diagnosis_code", type="string", maxLength=50),
     *             @OA\Property(property="location", type="string", maxLength=50),
     *             @OA\Property(property="summary_note", type="string"),
     *             @OA\Property(property="note_description", type="string"),
     *             @OA\Property(property="session_date", type="string", format="date"),
     *             @OA\Property(property="participants", type="string"),
     *             @OA\Property(property="pos", type="string"),
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
     *             @OA\Property(property="insuranceId", type="string"),
     *             @OA\Property(property="insurance_identifier", type="string"),
     *             @OA\Property(property="environmental_changes", type="string"),
     *             @OA\Property(property="BCBA_conducted_client_observations", type="boolean"),
     *             @OA\Property(property="BCBA_conducted_assessments", type="boolean"),
     *             @OA\Property(property="interventionProtocols", type="object"),
     *             @OA\Property(property="behaviorProtocols", type="object"),
     *             @OA\Property(property="intake_outcome", type="object"),
     *             @OA\Property(property="assessment_tools", type="object"),
     *             @OA\Property(property="replacementProtocols", type="object"),
     *             @OA\Property(property="modifications_needed_at_this_time", type="boolean"),
     *             @OA\Property(property="additional_goals_or_interventions", type="string"),
     *             @OA\Property(property="cargiver_participation", type="boolean"),
     *             @OA\Property(property="was_the_client_present", type="boolean"),
     *             @OA\Property(property="asked_and_clarified_questions_about_the_implementation_of", type="string"),
     *             @OA\Property(property="reinforced_caregiver_strengths_in", type="string"),
     *             @OA\Property(property="gave_constructive_feedback_on", type="string"),
     *             @OA\Property(property="recomended_more_practice_on", type="string"),
     *             @OA\Property(property="subtype", type="string")
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
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         description="Include related models (comma-separated). Options: patient, bip, location, provider, supervisor, doctor",
     *         required=false,
     *         @OA\Schema(type="string")
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
    public function show(Request $request, $id)
    {
        // Handle includes
        $allowedIncludes = ['patient', 'bip', 'location', 'provider', 'supervisor', 'doctor'];
        $includes = [];
        if ($request->has('include')) {
            $includes = array_filter(
                explode(',', $request->input('include')),
                fn($include) => in_array(trim($include), $allowedIncludes)
            );
        }

        $note = NoteBcba::with($includes)->find($id);

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
     *             @OA\Property(property="insurance_id", type="integer"),
     *             @OA\Property(property="patient_id", type="integer"),
     *             @OA\Property(property="patient_identifier", type="string"),
     *             @OA\Property(property="doctor_id", type="integer"),
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="diagnosis_code", type="string", maxLength=50),
     *             @OA\Property(property="location", type="string", maxLength=50),
     *             @OA\Property(property="summary_note", type="string"),
     *             @OA\Property(property="note_description", type="string"),
     *             @OA\Property(property="session_date", type="string", format="date"),
     *             @OA\Property(property="participants", type="string"),
     *             @OA\Property(property="pos", type="string"),
     *             @OA\Property(property="time_in", type="string", format="H:i:s"),
     *             @OA\Property(property="time_out", type="string", format="H:i:s"),
     *             @OA\Property(property="time_in2", type="string", format="H:i:s"),
     *             @OA\Property(property="time_out2", type="string", format="H:i:s"),
     *             @OA\Property(property="session_length_total", type="number", format="double"),
     *             @OA\Property(property="session_length_total2", type="number", format="double"),
     *             @OA\Property(property="next_session_is_scheduled_for", type="string", format="date"),
     *             @OA\Property(property="supervisor_id", type="integer"),
     *             @OA\Property(property="caregiver_goals", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="rbt_training_goals", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="provider_signature", type="string"),
     *             @OA\Property(property="provider_id", type="integer"),
     *             @OA\Property(property="supervisor_signature", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "ok", "no", "review"}),
     *             @OA\Property(property="billed", type="boolean"),
     *             @OA\Property(property="paid", type="boolean"),
     *             @OA\Property(property="cpt_code", type="string"),
     *             @OA\Property(property="location_id", type="integer"),
     *             @OA\Property(property="pa_service_id", type="integer"),
     *             @OA\Property(property="insuranceId", type="string"),
     *             @OA\Property(property="insurance_identifier", type="string"),
     *             @OA\Property(property="environmental_changes", type="string"),
     *             @OA\Property(property="BCBA_conducted_client_observations", type="boolean"),
     *             @OA\Property(property="BCBA_conducted_assessments", type="boolean"),
     *             @OA\Property(property="subtype", type="string"),
     *             @OA\Property(property="intake_outcome", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="assessment_tools", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="intervention_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="replacement_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="modifications_needed_at_this_time", type="boolean"),
     *             @OA\Property(property="additional_goals_or_interventions", type="string"),
     *             @OA\Property(property="cargiver_participation", type="boolean"),
     *             @OA\Property(property="was_the_client_present", type="boolean"),
     *             @OA\Property(property="asked_and_clarified_questions_about_the_implementation_of", type="string"),
     *             @OA\Property(property="reinforced_caregiver_strengths_in", type="string"),
     *             @OA\Property(property="gave_constructive_feedback_on", type="string"),
     *             @OA\Property(property="recomended_more_practice_on", type="string"),
     *             @OA\Property(property="demonstrated_intervention_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="demonstrated_replacement_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="behavior_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="md", type="string", maxLength=20),
     *             @OA\Property(property="md2", type="string", maxLength=20),
     *             @OA\Property(property="md3", type="string", maxLength=20)
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
     * @OA\Patch(
     *     path="/api/v2/notes/bcba/{id}",
     *     summary="Partially update a BCBA note",
     *     description="Updates specific fields of an existing BCBA note",
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
     *             @OA\Property(property="insurance_id", type="integer"),
     *             @OA\Property(property="patient_id", type="integer"),
     *             @OA\Property(property="patient_identifier", type="string"),
     *             @OA\Property(property="doctor_id", type="integer"),
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="diagnosis_code", type="string", maxLength=50),
     *             @OA\Property(property="location", type="string", maxLength=50),
     *             @OA\Property(property="summary_note", type="string"),
     *             @OA\Property(property="note_description", type="string"),
     *             @OA\Property(property="session_date", type="string", format="date"),
     *             @OA\Property(property="participants", type="string"),
     *             @OA\Property(property="pos", type="string"),
     *             @OA\Property(property="time_in", type="string", format="H:i:s"),
     *             @OA\Property(property="time_out", type="string", format="H:i:s"),
     *             @OA\Property(property="time_in2", type="string", format="H:i:s"),
     *             @OA\Property(property="time_out2", type="string", format="H:i:s"),
     *             @OA\Property(property="session_length_total", type="number", format="double"),
     *             @OA\Property(property="session_length_total2", type="number", format="double"),
     *             @OA\Property(property="next_session_is_scheduled_for", type="string", format="date"),
     *             @OA\Property(property="supervisor_id", type="integer"),
     *             @OA\Property(property="caregiver_goals", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="rbt_training_goals", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="provider_signature", type="string"),
     *             @OA\Property(property="provider_id", type="integer"),
     *             @OA\Property(property="supervisor_signature", type="string"),
     *             @OA\Property(property="status", type="string", enum={"pending", "ok", "no", "review"}),
     *             @OA\Property(property="billed", type="boolean"),
     *             @OA\Property(property="paid", type="boolean"),
     *             @OA\Property(property="cpt_code", type="string"),
     *             @OA\Property(property="location_id", type="integer"),
     *             @OA\Property(property="pa_service_id", type="integer"),
     *             @OA\Property(property="insuranceId", type="string"),
     *             @OA\Property(property="insurance_identifier", type="string"),
     *             @OA\Property(property="environmental_changes", type="string"),
     *             @OA\Property(property="BCBA_conducted_client_observations", type="boolean"),
     *             @OA\Property(property="BCBA_conducted_assessments", type="boolean"),
     *             @OA\Property(property="subtype", type="string"),
     *             @OA\Property(property="intake_outcome", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="assessment_tools", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="intervention_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="replacement_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="modifications_needed_at_this_time", type="boolean"),
     *             @OA\Property(property="additional_goals_or_interventions", type="string"),
     *             @OA\Property(property="cargiver_participation", type="boolean"),
     *             @OA\Property(property="was_the_client_present", type="boolean"),
     *             @OA\Property(property="asked_and_clarified_questions_about_the_implementation_of", type="string"),
     *             @OA\Property(property="reinforced_caregiver_strengths_in", type="string"),
     *             @OA\Property(property="gave_constructive_feedback_on", type="string"),
     *             @OA\Property(property="recomended_more_practice_on", type="string"),
     *             @OA\Property(property="demonstrated_intervention_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="demonstrated_replacement_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="behavior_protocols", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="md", type="string", maxLength=20),
     *             @OA\Property(property="md2", type="string", maxLength=20),
     *             @OA\Property(property="md3", type="string", maxLength=20)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Note updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/NoteBcba")
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
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function patch(Request $request, $id)
    {
        $note = NoteBcba::findOrFail($id);

        // Validate only the provided fields
        $validator = validator($request->all(), array_intersect_key(
            (new NoteBcbaRequest())->rules(),
            $request->all()
        ));

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $note->update($validator->validated());

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
