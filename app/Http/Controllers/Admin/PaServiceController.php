<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
     * Store a new PA service
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
            'status' => 'required|in:active,inactive,pending,expired',
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
     * Show a specific PA service
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
     * Update a PA service
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
            'status' => 'sometimes|required|in:active,inactive,pending,expired',
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
     * Delete a PA service
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
