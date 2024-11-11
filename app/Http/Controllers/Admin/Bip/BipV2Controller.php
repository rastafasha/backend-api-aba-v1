<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Models\Bip\Bip;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BipV2Controller extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v2/bips",
     *     summary="Get all BIPs with filters",
     *     tags={"BIPs"},
     *     @OA\Parameter(name="patient_id", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="doctor_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="type_of_assessment", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="date_from", in="query", required=false, @OA\Schema(type="string", format="date")),
     *     @OA\Parameter(name="date_to", in="query", required=false, @OA\Schema(type="string", format="date")),
     *     @OA\Parameter(name="per_page", in="query", required=false, @OA\Schema(type="integer", default=15)),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Bip"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Bip::query();

        // Apply filters
        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->has('type_of_assessment')) {
            $query->where('type_of_assessment', $request->type_of_assessment);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', Carbon::parse($request->date_from));
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', Carbon::parse($request->date_to));
        }

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $bips = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $bips
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/v2/bips",
     *     summary="Create a new BIP",
     *     tags={"BIPs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Bip")
     *     ),
     *     @OA\Response(response=201, description="BIP created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="BIP created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Bip")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());

        $bip = Bip::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'BIP created successfully',
            'data' => $bip
        ], 201);
    }


    /**
     * @OA\Get(
     *     path="/api/v2/bips/{id}",
     *     summary="Get BIP by ID",
     *     tags={"BIPs"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Bip")
     *         )
     *     ),
     *     @OA\Response(response=404, description="BIP not found")
     * )
     */
    public function show($id)
    {
        $bip = Bip::with([
            'patient',
            'doctor',
            'reduction_goals',
            'sustitution_goals',
            'family_envolments',
            'monitoring_evalutatings',
            'generalization_trainings',
            'crisis_plans',
            'de_escalation_techniques',
            'consent_to_treatments'
        ])->find($id);

        if (!$bip) {
            return response()->json([
                'status' => 'error',
                'message' => 'BIP not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $bip
        ]);
    }


    /**
     * @OA\Put(
     *     path="/api/v2/bips/{id}",
     *     summary="Update a BIP",
     *     tags={"BIPs"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Bip")
     *     ),
     *     @OA\Response(response=200, description="BIP updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="BIP updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Bip")
     *         )
     *     ),
     *     @OA\Response(response=404, description="BIP not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $bip = Bip::find($id);

        if (!$bip) {
            return response()->json([
                'status' => 'error',
                'message' => 'BIP not found'
            ], 404);
        }

        $validated = $request->validate($this->getValidationRules());

        $bip->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'BIP updated successfully',
            'data' => $bip->fresh()
        ]);
    }


    /**
     * @OA\Delete(
     *     path="/api/v2/bips/{id}",
     *     summary="Delete a BIP",
     *     tags={"BIPs"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="BIP deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="BIP deleted successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="BIP not found")
     * )
     */
    public function destroy($id)
    {
        $bip = Bip::find($id);

        if (!$bip) {
            return response()->json([
                'status' => 'error',
                'message' => 'BIP not found'
            ], 404);
        }

        $bip->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'BIP deleted successfully'
        ]);
    }

    private function getValidationRules()
    {
        return [
            'type_of_assessment' => 'required|integer',
            'documents_reviewed' => 'nullable|array',
            'client_id' => 'required|exists:users,id',
            'doctor_id' => 'nullable|exists:users,id',
            'patient_id' => 'nullable|string|max:50',
            'background_information' => 'nullable|string',
            'previus_treatment_and_result' => 'nullable|string',
            'current_treatment_and_progress' => 'nullable|string',
            'education_status' => 'nullable|string',
            'phisical_and_medical_status' => 'nullable|string',
            'maladaptives' => 'nullable|array',
            'assestment_conducted' => 'nullable|string',
            'assestment_conducted_options' => 'nullable|array',
            'prevalent_setting_event_and_atecedents' => 'nullable|array',
            'assestmentEvaluationSettings' => 'nullable|array',
            'interventions' => 'nullable|array',
            'strengths' => 'nullable|string',
            'weakneses' => 'nullable|string',
            'hypothesis_based_intervention' => 'nullable|string',
            'phiysical_and_medical' => 'nullable|string',
            'phiysical_and_medical_status' => 'nullable|array',
            'tangibles' => 'nullable|array',
            'attention' => 'nullable|array',
            'escape' => 'nullable|array',
            'sensory' => 'nullable|array',
        ];
    }
}
