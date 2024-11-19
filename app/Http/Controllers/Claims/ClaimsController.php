<?php

namespace App\Http\Controllers\Claims;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Services\ClaimMdService;
use App\Services\ClaimsService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedClaimResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Claim")),
 *     @OA\Property(property="first_page_url", type="string"),
 *     @OA\Property(property="from", type="integer"),
 *     @OA\Property(property="last_page", type="integer"),
 *     @OA\Property(property="last_page_url", type="string"),
 *     @OA\Property(property="next_page_url", type="string", nullable=true),
 *     @OA\Property(property="path", type="string"),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true),
 *     @OA\Property(property="to", type="integer"),
 *     @OA\Property(property="total", type="integer")
 * )
 */
class ClaimsController extends Controller
{
    private $claimsService;
    private $claimMdService;

    public function __construct(ClaimsService $claimsService, ClaimMdService $claimMdService)
    {
        $this->claimsService = $claimsService;
        $this->claimMdService = $claimMdService;
    }

    /**
     * @OA\Get(
     *     path="/api/v2/claims",
     *     summary="Get paginated claims list",
     *     description="Retrieves a paginated list of claims with optional filters",
     *     tags={"Claims"},
     *     @OA\Parameter(name="status", in="query", description="Filter by status", @OA\Schema(type="string")),
     *     @OA\Parameter(name="filename", in="query", description="Filter by filename", @OA\Schema(type="string")),
     *     @OA\Parameter(name="start_date", in="query", description="Filter by start date (Y-m-d)", @OA\Schema(type="string", format="date")),
     *     @OA\Parameter(name="end_date", in="query", description="Filter by end date (Y-m-d)", @OA\Schema(type="string", format="date")),
     *     @OA\Parameter(name="rbt_note_ids", in="query", description="Filter by RBT note IDs", @OA\Schema(type="array", @OA\Items(type="integer"))),
     *     @OA\Parameter(name="bcba_note_ids", in="query", description="Filter by BCBA note IDs", @OA\Schema(type="array", @OA\Items(type="integer"))),
     *     @OA\Parameter(name="per_page", in="query", description="Number of items per page", @OA\Schema(type="integer", default=15)),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedClaimResponse")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Claim::query();

        if ($request->has('filename')) {
            $query->where('filename', 'like', '%' . $request->filename . '%');
        }

        if ($request->has('rbt_note_ids')) {
            $rbtNoteIds = is_array($request->rbt_note_ids) ? $request->rbt_note_ids : [$request->rbt_note_ids];
            $query->where(function ($q) use ($rbtNoteIds) {
                foreach ($rbtNoteIds as $noteId) {
                    $q->orWhereJsonContains('rbt_notes_ids', $noteId);
                }
            });
        }

        if ($request->has('bcba_note_ids')) {
            $bcbaNoteIds = is_array($request->bcba_note_ids) ? $request->bcba_note_ids : [$request->bcba_note_ids];
            $query->where(function ($q) use ($bcbaNoteIds) {
                foreach ($bcbaNoteIds as $noteId) {
                    $q->orWhereJsonContains('bcba_notes_ids', $noteId);
                }
            });
        }

        $perPage = $request->input('per_page', 15);
        $claims = $query->filterByCreatedAtRange($request->date_start, $request->date_end)
            ->filterByStatus($request->status)
            ->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $claims
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/claims",
     *     summary="Create a new claim",
     *     tags={"Claims"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="notes_rbt_ids", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="notes_bcba_ids", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="file_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Claim created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Claim created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Claim")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'notes_rbt_ids' => 'array',
            'notes_bcba_ids' => 'array',
            'file_name' => 'nullable|string'
        ]);

        $fileContent = $this->claimsService->generateFromNotes(
            $validated['notes_rbt_ids'] ?? [],
            $validated['notes_bcba_ids'] ?? []
        );

        $claim = Claim::create([
            'status' => 'pending',
            'rbt_notes_ids' => $validated['notes_rbt_ids'] ?? [],
            'bcba_notes_ids' => $validated['notes_bcba_ids'] ?? [],
            'filename' => $validated['file_name'] ?? 'Claim.dat',
            'content' => $fileContent,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Claim created successfully',
            'data' => $claim
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/claims/{id}",
     *     summary="Get a single claim",
     *     tags={"Claims"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Claim ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Claim")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Claim not found"
     *     )
     * )
     */
    public function show($id)
    {
        $claim = Claim::find($id);

        if (!$claim) {
            return response()->json([
                'status' => 'error',
                'message' => 'Claim not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $claim
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/claims/{id}",
     *     summary="Update a claim",
     *     tags={"Claims"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Claim ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="notes_rbt_ids", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="notes_bcba_ids", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="file_name", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Claim updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Claim updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Claim")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Claim not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $claim = Claim::findOrFail($id);

        $validated = $request->validate([
            'notes_rbt_ids' => 'array',
            'notes_bcba_ids' => 'array',
            'file_name' => 'nullable|string',
            'status' => 'string'
        ]);

        $needsRegeneration = false;
        if (
            ($request->has('notes_rbt_ids') && $claim->rbt_notes_ids != $validated['notes_rbt_ids']) ||
            ($request->has('notes_bcba_ids') && $claim->bcba_notes_ids != $validated['notes_bcba_ids'])
        ) {
            $needsRegeneration = true;
        }

        if ($needsRegeneration) {
            $fileContent = $this->claimsService->generateFromNotes(
                $validated['notes_rbt_ids'] ?? $claim->rbt_notes_ids,
                $validated['notes_bcba_ids'] ?? $claim->bcba_notes_ids
            );
            $claim->content = $fileContent;
        }

        $claim->update([
            'rbt_notes_ids' => $validated['notes_rbt_ids'] ?? $claim->rbt_notes_ids,
            'bcba_notes_ids' => $validated['notes_bcba_ids'] ?? $claim->bcba_notes_ids,
            'filename' => $validated['file_name'] ?? $claim->filename,
            'status' => $validated['status'] ?? $claim->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Claim updated successfully',
            'data' => $claim->fresh()
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/claims/{id}",
     *     summary="Delete a claim",
     *     tags={"Claims"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Claim ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Claim deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Claim deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Claim not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $claim = Claim::findOrFail($id);
        $claim->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Claim deleted successfully'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/claims/{id}/send-to-claim-md",
     *     summary="Send a claim to Claim MD",
     *     tags={"Claims"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Claim ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Claim sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Claim sent successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Claim not found"
     *     )
     * )
     */
    public function sendToClaimMd($id)
    {

        $claim = Claim::findOrFail($id);

        $this->claimMdService->sendEdiFile($claim->content, $claim->filename);

        $claim->update([
            'status' => 'sent'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Claim sent successfully'
        ]);
    }
}
