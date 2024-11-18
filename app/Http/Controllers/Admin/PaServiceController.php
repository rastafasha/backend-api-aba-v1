<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Get(
 *     path="/api/patients/{patient_id}/pa-services",
 *     summary="Get all PA services for a patient",
 *     tags={"PA Services"},
 *     @OA\Parameter(
 *         name="patient_id",
 *         in="path",
 *         required=true,
 *         description="ID of the patient",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of PA services",
 *         @OA\JsonContent(
 *             @OA\Property(property="pa_services", type="array", @OA\Items(ref="#/components/schemas/PaService"))
 *         )
 *     ),
 *     @OA\Response(response=404, description="Patient not found")
 * )
 */
class PaServiceController extends Controller
{
    /**
     * Get all PA services for a patient
     */
    public function index($patient_id)
    {
        $patient = Patient::where('patient_id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found'
            ], 404);
        }

        $paServices = $patient->paServices()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'pa_services' => $paServices
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/patients/{patient_id}/pa-services",
     *     summary="Create a new PA service",
     *     tags={"PA Services"},
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
     *             required={"pa_services", "cpt", "n_units", "start_date", "end_date"},
     *             @OA\Property(property="pa_services", type="string", example="Behavioral Analysis"),
     *             @OA\Property(property="cpt", type="string", example="97151"),
     *             @OA\Property(property="n_units", type="integer", example=8),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-04-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PA service created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="PA service created successfully"),
     *             @OA\Property(property="pa_service", ref="#/components/schemas/PaService")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Patient not found"),
     *     @OA\Response(response=422, description="Validation failed")
     * )
     */
    public function store(Request $request, $patient_id)
    {
        $patient = Patient::where('patient_id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pa_services' => 'required|string|max:255',
            'cpt' => 'required|string|max:255',
            'n_units' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $paService = new PaService($request->all());
        $paService->patient_id = $patient->id;
        $paService->save();

        return response()->json([
            'message' => 'PA service created successfully',
            'pa_service' => $paService
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/patients/{patient_id}/pa-services/{id}",
     *     summary="Get a specific PA service",
     *     tags={"PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         description="ID of the patient",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the PA service",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PA service details",
     *         @OA\JsonContent(
     *             @OA\Property(property="pa_service", ref="#/components/schemas/PaService")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Patient or PA service not found")
     * )
     */
    public function show($patient_id, $id)
    {
        $patient = Patient::where('patient_id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found'
            ], 404);
        }

        $paService = $patient->paServices()->find($id);

        if (!$paService) {
            return response()->json([
                'error' => 'PA service not found'
            ], 404);
        }

        return response()->json([
            'pa_service' => $paService
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/patients/{patient_id}/pa-services/{id}",
     *     summary="Update a PA service",
     *     tags={"PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         description="ID of the patient",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the PA service",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pa_services", type="string", example="Behavioral Analysis"),
     *             @OA\Property(property="cpt", type="string", example="97151"),
     *             @OA\Property(property="n_units", type="integer", example=8),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-04-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PA service updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="PA service updated successfully"),
     *             @OA\Property(property="pa_service", ref="#/components/schemas/PaService")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Patient or PA service not found"),
     *     @OA\Response(response=422, description="Validation failed")
     * )
     */
    public function update(Request $request, $patient_id, $id)
    {
        $patient = Patient::where('patient_id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found'
            ], 404);
        }

        $paService = $patient->paServices()->find($id);

        if (!$paService) {
            return response()->json([
                'error' => 'PA service not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pa_services' => 'sometimes|required|string|max:255',
            'cpt' => 'sometimes|required|string|max:255',
            'n_units' => 'sometimes|required|integer|min:0',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $paService->update($request->all());

        return response()->json([
            'message' => 'PA service updated successfully',
            'pa_service' => $paService
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/patients/{patient_id}/pa-services/{id}",
     *     summary="Delete a PA service",
     *     tags={"PA Services"},
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="path",
     *         required=true,
     *         description="ID of the patient",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the PA service",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PA service deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="PA service deleted successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Patient or PA service not found")
     * )
     */
    public function destroy($patient_id, $id)
    {
        $patient = Patient::where('patient_id', $patient_id)->first();

        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found'
            ], 404);
        }

        $paService = $patient->paServices()->find($id);

        if (!$paService) {
            return response()->json([
                'error' => 'PA service not found'
            ], 404);
        }

        $paService->delete();

        return response()->json([
            'message' => 'PA service deleted successfully'
        ]);
    }
}
