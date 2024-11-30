<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\PaServiceRequest;

/**
 * @OA\Schema(
 *     schema="PaginatedPaServiceResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PaService")),
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
class PaServiceV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/patients/{patient_id}/pa-services",
     *     summary="Get paginated PA services list for a patient",
     *     tags={"Admin/PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         description="ID of the patient",
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
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/PaginatedPaServiceResponse"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Patient not found")
     * )
     */
    public function index(Request $request, $patient_id)
    {
        $patient = Patient::where('id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $paServices = $patient->paServices()
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => $paServices
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/patients/{patient_id}/pa-services",
     *     summary="Create a new PA service",
     *     tags={"Admin/PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         description="ID of the patient",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pa_service", "cpt", "n_units", "start_date", "end_date"},
     *             @OA\Property(property="pa_service", type="string", example="Behavioral Analysis"),
     *             @OA\Property(property="cpt", type="string", example="97151"),
     *             @OA\Property(property="n_units", type="integer", example=8),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-04-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PA service created successfully"
     *     )
     * )
     */
    public function store(PaServiceRequest $request, $patient_id)
    {
        $patient = Patient::where('id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $validated = $request->validated();
        $paService = new PaService($validated);
        $paService->patient_id = $patient->id;
        $paService->save();

        return response()->json([
            'status' => 'success',
            'message' => 'PA service created successfully',
            'data' => $paService
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/patients/{patient_id}/pa-services/{id}",
     *     summary="Get a single PA service",
     *     tags={"Admin/PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function show($patient_id, $id)
    {
        $patient = Patient::where('id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $paService = $patient->paServices()->find($id);

        if (!$paService) {
            return response()->json([
                'status' => 'error',
                'message' => 'PA service not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $paService
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/patients/{patient_id}/pa-services/{id}",
     *     summary="Update a PA service",
     *     tags={"Admin/PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pa_service", type="string"),
     *             @OA\Property(property="cpt", type="string"),
     *             @OA\Property(property="n_units", type="integer"),
     *             @OA\Property(property="start_date", type="string", format="date"),
     *             @OA\Property(property="end_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PA service updated successfully"
     *     )
     * )
     */
    public function update(PaServiceRequest $request, $patient_id, $id)
    {
        $patient = Patient::where('id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $paService = $patient->paServices()->find($id);

        if (!$paService) {
            return response()->json([
                'status' => 'error',
                'message' => 'PA service not found'
            ], 404);
        }

        $validated = $request->validated();
        $paService->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'PA service updated successfully',
            'data' => $paService
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/patients/{patient_id}/pa-services/{id}",
     *     summary="Delete a PA service",
     *     tags={"Admin/PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PA service deleted successfully"
     *     )
     * )
     */
    public function destroy($patient_id, $id)
    {
        $patient = Patient::where('id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $paService = $patient->paServices()->find($id);

        if (!$paService) {
            return response()->json([
                'status' => 'error',
                'message' => 'PA service not found'
            ], 404);
        }

        $paService->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'PA service deleted successfully'
        ]);
    }
}
