<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Http\Controllers\Controller;
use App\Http\Requests\BipRequest;
use App\Models\Bip\Bip;
use Illuminate\Http\Request;

class BipV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/bips",
     *     summary="List all BIPs",
     *     description="Retrieve a paginated list of behavior intervention plans (BIPs) with optional filters and their subplans.",
     *     tags={"BIPs"},
     *     @OA\Parameter(
     *         name="patient_identifier",
     *         in="query",
     *         description="Filter BIPs by patient identifier",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
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
        if ($request->has('patient_identifier')) {
            $query->where('patient_identifier', $request->patient_identifier);
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $bips = $query->filterByCreatedAtRange($request->date_from, $request->date_to)
            ->with([
                'maladaptives',
                'replacements',
                'caregiver_trainings',
                'rbt_trainings',
                'maladaptives.objectives',
                'replacements.objectives',
                'caregiver_trainings.objectives',
                'rbt_trainings.objectives',
                'consent_to_treatment'
            ])
            ->orderBy('created_at', 'desc')
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
     *     @OA\Response(
     *         response=201,
     *         description="BIP created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="BIP created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Bip")
     *         )
     *     )
     * )
     */
    public function store(BipRequest $request)
    {
        $validated = $request->validated();
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="BIP ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Bip")
     *         )
     *     )
     * )
     */
    public function show(Request $request, $id)
    {
        $includeArray = [
            'doctor',
            'maladaptives',
            'replacements',
            'caregiver_trainings',
            'rbt_trainings',
            'maladaptives.objectives',
            'replacements.objectives',
            'caregiver_trainings.objectives',
            'rbt_trainings.objectives',
            'consent_to_treatment'
        ];

        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            if (in_array('patient', $includes)) {
                $includeArray[] = 'patient';
            }
        }
        $bip = Bip::with($includeArray)->find($id);

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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="BIP ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Bip")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="BIP updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="BIP updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Bip")
     *         )
     *     )
     * )
     */
    public function update(BipRequest $request, $id)
    {
        $bip = Bip::findOrFail($id);
        $validated = $request->validated();
        $bip->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'BIP updated successfully',
            'data' => $bip->fresh()->load([
                'maladaptives',
                'replacements',
                'caregiver_trainings',
                'rbt_trainings',
                'maladaptives.objectives',
                'replacements.objectives',
                'caregiver_trainings.objectives',
                'rbt_trainings.objectives',
                'consent_to_treatment'
            ])
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
}
