<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\ConsentToTreatment;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PaginatedConsentToTreatmentResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ConsentToTreatment")),
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
class ConsentToTreatmentV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/consent-to-treatments",
     *     summary="Get paginated consent to treatments",
     *     description="Retrieves a paginated list of consent to treatments with optional filters",
     *     tags={"Admin/Consent To Treatments"},
     *     @OA\Parameter(
     *         name="bip_id",
     *         in="query",
     *         description="Filter by BIP ID",
     *         required=false,
     *         @OA\Schema(type="integer")
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
     *                 ref="#/components/schemas/PaginatedConsentToTreatmentResponse"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = ConsentToTreatment::query();

        if ($request->has('bip_id')) {
            $query->where('bip_id', $request->bip_id);
        }

        $perPage = $request->input('per_page', 15);
        $consents = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $consents
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/consent-to-treatments",
     *     summary="Create a new consent to treatment",
     *     description="Creates a new consent to treatment with the provided data",
     *     tags={"Admin/Consent To Treatments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bip_id"},
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="analyst_signature", type="string"),
     *             @OA\Property(property="analyst_signature_date", type="string", format="date"),
     *             @OA\Property(property="parent_guardian_signature", type="string"),
     *             @OA\Property(property="parent_guardian_signature_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Consent to treatment created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Consent to treatment created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/ConsentToTreatment")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = ConsentToTreatment::validate($request->all());

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $consent = ConsentToTreatment::create($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Consent to treatment created successfully',
            'data' => $consent
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/consent-to-treatments/{id}",
     *     summary="Get a single consent to treatment",
     *     description="Retrieves a specific consent to treatment by its ID",
     *     tags={"Admin/Consent To Treatments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the consent to treatment",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/ConsentToTreatment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Consent to treatment not found"
     *     )
     * )
     */
    public function show($id)
    {
        $consent = ConsentToTreatment::find($id);

        if (!$consent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Consent to treatment not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $consent
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/consent-to-treatments/{id}",
     *     summary="Update a consent to treatment",
     *     description="Updates an existing consent to treatment",
     *     tags={"Admin/Consent To Treatments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the consent to treatment",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="bip_id", type="integer"),
     *             @OA\Property(property="analyst_signature", type="string"),
     *             @OA\Property(property="analyst_signature_date", type="string", format="date"),
     *             @OA\Property(property="parent_guardian_signature", type="string"),
     *             @OA\Property(property="parent_guardian_signature_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Consent to treatment updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Consent to treatment not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $consent = ConsentToTreatment::find($id);

        if (!$consent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Consent to treatment not found'
            ], 404);
        }

        $validated = ConsentToTreatment::validate($request->all());

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        $consent->update($validated->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Consent to treatment updated successfully',
            'data' => $consent
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/consent-to-treatments/{id}",
     *     summary="Delete a consent to treatment",
     *     description="Deletes an existing consent to treatment",
     *     tags={"Admin/Consent To Treatments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the consent to treatment",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Consent to treatment deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Consent to treatment not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $consent = ConsentToTreatment::find($id);

        if (!$consent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Consent to treatment not found'
            ], 404);
        }

        $consent->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Consent to treatment deleted successfully'
        ]);
    }
}
