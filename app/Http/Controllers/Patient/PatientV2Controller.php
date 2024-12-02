<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PaService;
use App\Http\Requests\PaServiceRequest;

/**
 * @OA\Schema(
 *     schema="PaginatedPatientResponse",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Patient")),
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
class PatientV2Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/patients",
     *     summary="Get paginated patients list",
     *     description="Retrieves a paginated list of patients with optional filters",
     *     tags={"Admin/Patients"},
     *     @OA\Parameter(name="include", in="query", description="Include related models (comma-separated). Options: insurance", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="search", in="query", description="Search in first name, last name and email", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="patient_id", in="query", description="Filter by patient ID", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="status", in="query", description="Filter by status", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="gender", in="query", description="Filter by gender", required=false, @OA\Schema(type="integer", enum={1, 2})),
     *     @OA\Parameter(name="insurer_id", in="query", description="Filter by insurance provider", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="city", in="query", description="Filter by city", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="state", in="query", description="Filter by state", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="per_page", in="query", description="Number of items per page", required=false, @OA\Schema(type="integer", default=15)),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/PaginatedPatientResponse")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            if (in_array('insurance', $includes)) {
                $query->with('insurances');
            }
        }

        // Search in name and email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply filters
        if ($request->has('patient_identifier')) {
            $query->where('patient_identifier', $request->patient_identifier);
        }


        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->has('insurer_id')) {
            $query->where('insurer_id', $request->insurer_id);
        }

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        if ($request->has('state')) {
            $query->where('state', $request->state);
        }

        // Get paginated results
        $perPage = $request->input('per_page', 15);
        $patients = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $patients,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v2/patients",
     *     summary="Create a new patient",
     *     description="Creates a new patient record",
     *     tags={"Admin/Patients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Patient created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Patient")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());

        $patient = Patient::create($validated);


        // if ($patient->id && $request->has('pa_services') && is_array($request->pa_services)) {
        //     foreach ($request->pa_services as $pa) {
        //         $validatedData = PaService::validate($pa);
        //         $paService = new PaService($validatedData);
        //         $paService->patient_id = $patient->id;
        //         // $paService->save();
        //         $paService = PaService::create($request->all());
        //     }
        // }


        if ($patient->id && $request->has('pa_services') && is_array($request->pa_services)) {
            foreach ($request->pa_services as $pa) {
                $validatedData = PaService::validate($pa);
                $paService = new PaService($validatedData);
                $paService->patient_id = $patient->id;
                $paService->save();
                // $paService = PaService::create($request->all());
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Patient created successfully',
            'data' => $patient
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/patients/{id}",
     *     summary="Get a single patient",
     *     description="Retrieves a specific patient by their ID",
     *     tags={"Admin/Patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Patient")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $patient = Patient::with(['paServices'])->find($id);

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $patient,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v2/patients/{id}",
     *     summary="Update a patient",
     *     description="Updates an existing patient record",
     *     tags={"Admin/Patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient updated successfully"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        // $validated = $request->validate($this->getValidationRules());


        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        if ($patient->id && $request->has('pa_services') && is_array($request->pa_services)) {
            foreach ($request->pa_services as $pa) {
                $validatedData = PaService::validate($pa);
                $paService = new PaService($validatedData);
                $paService->patient_id = $patient->id;
                $paService->update();
                // $paService = PaService::create($request->all());
            }
        }


        // $patient->update($validated);
        $patient->update($request->all());


        return response()->json([
            'status' => 'success',
            'message' => 'Patient updated successfully',
            'data' => $patient
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/patients/{id}",
     *     summary="Delete a patient",
     *     description="Soft deletes an existing patient record",
     *     tags={"Admin/Patients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient deleted successfully"
     *     )
     * )
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $patient->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Patient deleted successfully'
        ]);
    }

    private function getValidationRules($id = null)
    {
        return [
            // Basic Information
            'first_name' => 'required|string|max:250',
            'last_name' => 'required|string|max:250',
            'email' => 'nullable|email|max:250',
            'phone' => 'nullable|string|max:25',
            'patient_identifier' => $id ? 'nullable|string|unique:patients,patient_identifier,' . $id : 'nullable|string|unique:patients',
            // 'patient_id' => $id ? 'nullable|number|unique:patients,patient_id,' . $id : 'nullable|number|unique:patients',
            'birth_date' => 'nullable|date:Y-m-d|before:today',
            'gender' => 'required|integer|in:1,2',
            // 'age' => 'nullable|string|max:50',
            'avatar' => 'nullable|string',

            // Contact Information
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string|max:150',
            'zip' => 'nullable|string|max:150',
            'language' => 'nullable|string|max:150',

            // Guardian Information
            'parent_guardian_name' => 'nullable|string|max:150',
            'relationship' => 'nullable|string|max:150',
            'home_phone' => 'nullable|string|max:150',
            'work_phone' => 'nullable|string|max:150',

            // School Information
            'school_name' => 'nullable|string|max:150',
            'school_number' => 'nullable|string|max:150',
            'education' => 'nullable|string|max:150',
            'profession' => 'nullable|string|max:150',

            // Schedule Information
            'schedule' => 'nullable|string',
            'summer_schedule' => 'nullable|string',
            'special_note' => 'nullable|string',

            // Medical & Insurance Information
            'diagnosis_code' => 'nullable|string',
            'patient_control' => 'nullable|string',
            'insurer_id' => 'nullable|exists:insurances,id',
            'insurer_secondary_id' => 'nullable|exists:insurances,id',
            // 'insuranceId' => 'nullable|string|max:50',
            'insurance_identifier' => 'nullable|string',
            'insurance_secondary_identifier' => 'nullable|string',
            'eqhlid' => 'nullable|string',
            'elegibility_date' => 'nullable|date',
            'pos_covered' => 'nullable|array',
            'deductible_individual_I_F' => 'nullable|string|max:150',
            'balance' => 'nullable|string|max:150',
            'coinsurance' => 'nullable|string|max:150',
            'copayments' => 'nullable|string|max:150',
            'oop' => 'nullable|string|max:150',

            // Provider Assignments
            'rbt_home_id' => 'nullable|exists:users,id',
            'rbt2_school_id' => 'nullable|exists:users,id',
            'bcba_home_id' => 'nullable|exists:users,id',
            'bcba2_school_id' => 'nullable|exists:users,id',
            'clin_director_id' => 'nullable|exists:users,id',
            'location_id' => 'nullable|exists:locations,id',

            // Status Fields
            'status' => ['nullable', Rule::in([
                'incoming', 'active', 'inactive', 'onHold', 'onDischarge',
                'waitintOnPa', 'waitintOnPaIa', 'waitintOnIa',
                'waitintOnServices', 'waitintOnStaff', 'waitintOnSchool'
            ])],

            // Intake Status Fields
            'welcome' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'consent' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'insurance_card' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'eligibility' => ['nullable', Rule::in([
                'pending', 'waiting', 'reviewing', 'psycho eval',
                'requested', 'need new', 'yes', 'no', '2 insurance'
            ])],
            'mnl' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'referral' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'ados' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'iep' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'asd_diagnosis' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'cde' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'submitted' => ['nullable', Rule::in([
                'waiting', 'reviewing', 'psycho eval', 'requested',
                'need new', 'yes', 'no', '2 insurance'
            ])],
            'interview' => ['nullable', Rule::in([
                'pending', 'send', 'receive', 'no apply'
            ])],

            // Additional Settings
            // 'pa_assessments' => 'nullable|json',
            // 'telehealth' => ['nullable', 'string', 'max:50', Rule::in(['true', 'false'])],
            // 'pay' => ['nullable', 'string', 'max:50', Rule::in(['true', 'false'])],
            'telehealth' => 'nullable|boolean',
            'pay' => 'nullable|boolean',
        ];
    }
}
