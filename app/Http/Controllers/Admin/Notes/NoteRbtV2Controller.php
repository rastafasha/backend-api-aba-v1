<?php

namespace App\Http\Controllers\Admin\Notes;

use App\Http\Controllers\Controller;
use App\Http\Resources\Note\NoteRbtResource;
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
      ->with(['patient', 'doctor', 'bips', 'location'])
      ->paginate($perPage);

    return response()->json([
      'status' => 'success',
      'data' => NoteRbtResource::collection($notes)
    ]);
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
    $note = NoteRbt::with(['patient', 'doctor', 'bips', 'location'])
      ->find($id);

    if (!$note) {
      return response()->json([
        'status' => 'error',
        'message' => 'Note not found'
      ], 404);
    }

    return response()->json([
      'status' => 'success',
      'data' => NoteRbtResource::make($note)
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
   *             @OA\Property(property="session_date", type="string", format="date", example="2023-12-01"),
   *             @OA\Property(property="patient_id", type="integer", example=1),
   *             @OA\Property(property="doctor_id", type="integer", example=1),
   *             @OA\Property(property="bip_id", type="integer", example=1),
   *             @OA\Property(property="location_id", type="integer", example=1),
   *             @OA\Property(property="notes", type="string", example="Session notes here"),
   *             @OA\Property(property="status", type="string", example="completed")
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
   *         description="Note not found",
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="status", type="string", example="error"),
   *             @OA\Property(property="message", type="string", example="Note not found")
   *         )
   *     )
   * )
   */
  public function update(Request $request, $id)
  {
    $note = NoteRbt::find($id);

    if (!$note) {
      return response()->json([
        'status' => 'error',
        'message' => 'Note not found'
      ], 404);
    }

    // Validate request
    $validated = $request->validate([
      'session_date' => 'required|date',
      'patient_id' => 'required|exists:patients,id',
      'doctor_id' => 'required|exists:doctors,id',
      'bip_id' => 'nullable|exists:bips,id',
      'location_id' => 'nullable|exists:locations,id',
      'notes' => 'nullable|string',
      'status' => 'nullable|string'
    ]);

    $note->update($validated);

    return response()->json([
      'status' => 'success',
      'message' => 'Note updated successfully',
      'data' => NoteRbtResource::make($note->fresh(['patient', 'doctor', 'bips', 'location']))
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
