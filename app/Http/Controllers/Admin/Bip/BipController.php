<?php

namespace App\Http\Controllers\Admin\Bip;

use App\Models\User;
use App\Models\Bip\Bip;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Models\Bip\ReductionGoal;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bip\BipResource;
use App\Services\UnitCalculationService;
use App\Http\Resources\Bip\BipCollection;
use App\Http\Resources\Patient\PatientCollection;
use App\Http\Resources\Bip\ConsentToTreatmentResource;

class BipController extends Controller
{
    protected $unitCalculationService;

    public function __construct(UnitCalculationService $unitCalculationService)
    {
        $this->unitCalculationService = $unitCalculationService;
    }

    public function getAvailableUnits(Request $request, string $patient_identifier, string $cptCode)
    {
        $provider = $request->query('provider');
        $availableUnits = $this->unitCalculationService->calculateAvailableUnits($patient_identifier, $cptCode, $provider);

        return response()->json([
            'patient_identifier' => $patient_identifier,
            'cpt_code' => $cptCode,
            'provider' => $provider,
            'available_units' => $availableUnits
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $patientID = $request->patientID;
        // $name_doctor = $request->search;
        // $date = $request->date;

        // $appointments = Appointment::filterAdvanceBip($patientID, $name_doctor, $date)->orderBy("id", "desc")
        //                     ->paginate(10);
        // return response()->json([
        //     "total"=>$appointments->total(),
        //     "appointments"=> AppointmentCollection::make($appointments)
        // ]);

        // $bips = Bip::orderBy("id", "desc")
        //                     ->paginate(10);

        // return response()->json([
        //     // "total"=>$payments->total(),
        //     "bips" => BipCollection::make($bips) ,

        // ]);
    }

    public function config()
    {
        $users = User::orderBy("id", "desc")
            // ->whereHas("roles", function($q){
            //     $q->where("name","like","%DOCTOR%");
            // })
            ->get();

        return response()->json([
            "doctors" => $users->map(function ($user) {
                return [
                    "id" => $user->id,
                    "full_name" => $user->name . ' ' . $user->surname,
                ];
            })
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = null;
        $patient = Patient::where("patient_identifier", $request->patient_identifier)->first();
        $doctor = User::where("id", $request->doctor_id)->first();

        $request->request->add(["documents_reviewed" => json_encode($request->documents_reviewed)]);
        $request->request->add(["maladaptives" => json_encode($request->maladaptives)]);
        $request->request->add(["assestment_conducted_options" => json_encode($request->assestment_conducted_options)]);
        $request->request->add(["prevalent_setting_event_and_atecedents" => json_encode($request->prevalent_setting_event_and_atecedents)]);
        $request->request->add(["interventions" => json_encode($request->interventions)]);
        $request->request->add(["pos_covered" => json_encode($request->pos_covered)]);
        $request->request->add(["assestmentEvaluationSettings" => json_encode($request->assestmentEvaluationSettings)]);
        $request->request->add(["tangibles" => json_encode($request->tangibles)]);
        $request->request->add(["attention" => json_encode($request->attention)]);
        $request->request->add(["escape" => json_encode($request->escape)]);
        $request->request->add(["sensory" => json_encode($request->sensory)]);
        $request->request->add(["phiysical_and_medical_status" => json_encode($request->phiysical_and_medical_status)]);

        $bip = Bip::create($request->all());


        return response()->json([
            "message" => 200,
            "bip" => $bip,
            "type_of_assessment" => $bip->type_of_assessment,
            "documents_reviewed" =>
            is_string($bip->documents_reviewed)
                ? json_decode($bip->documents_reviewed)
                : $bip->documents_reviewed,
            "maladaptives" =>
            is_string($bip->maladaptives)
                ? json_decode($bip->maladaptives)
                : $bip->maladaptives,
            "assestment_conducted_options" =>
            is_string($bip->assestment_conducted_options)
                ? json_decode($bip->assestment_conducted_options)
                : $bip->assestment_conducted_options,
            "assestmentEvaluationSettings" =>
            is_string($bip->assestmentEvaluationSettings)
                ? json_decode($bip->assestmentEvaluationSettings)
                : $bip->assestmentEvaluationSettings,
            "access_to_tangibles" =>
            is_string($bip->access_to_tangibles)
                ? json_decode($bip->access_to_tangibles)
                : $bip->access_to_tangibles,
            "phiysical_and_medical_status" =>
            is_string($bip->phiysical_and_medical_status)
                ? json_decode($bip->phiysical_and_medical_status)
                : $bip->phiysical_and_medical_status,
            "prevalent_setting_event_and_atecedents" =>
            is_string($bip->prevalent_setting_event_and_atecedents)
                ? json_decode($bip->prevalent_setting_event_and_atecedents)
                : $bip->prevalent_setting_event_and_atecedents,
            "interventions" =>
            is_string($bip->interventions)
                ? json_decode($bip->interventions)
                : $bip->interventions,
            "pos_covered" =>
            is_string($bip->pos_covered)
                ? json_decode($bip->pos_covered)
                : $bip->pos_covered,
            "client_id" => $bip->client_id,
            "patient_identifier" => $bip->patient_identifier,
            "doctor_id" => $bip->doctor_id,
            "doctor" => $bip->doctor_id ?
                [
                    "id" => $doctor->id,
                    "email" => $doctor->email,
                    "full_name" => $doctor->name . ' ' . $doctor->surname,
                ] : null,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bip = Bip::findOrFail($id);



        return response()->json([
            "id" => $bip->id,
            "bip" => $bip,
            "type_of_assessment" => $bip->type_of_assessment,
        ]);
    }
    //se obtiene el usuario
    public function showProfile($patient_identifier)
    {
        $patient = Patient::where("patient_identifier", $patient_identifier)->first();
        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found'
            ], 404);
        }

        $paServices = $this->getFormattedPaServices($patient_identifier);

        return response()->json([
            "patient" => $patient->patient_identifier ? [
                "id" => $patient->id,
                "patient_identifier" => $patient->patient_identifier,
                "location_id" => $patient->location_id,
                "first_name" => $patient->first_name,
                "last_name" => $patient->last_name,
                "phone" => $patient->phone,
                "parent_guardian_name" => $patient->parent_guardian_name,
                "relationship" => $patient->relationship,
                "address" => $patient->address,
                "age" => $patient->age,
                "birth_date" => $patient->birth_date,
                "pos_covered" =>
                is_string($patient->pos_covered)
                    ? json_decode($patient->pos_covered)
                    : $patient->pos_covered,
                "pa_assessments" => json_encode($paServices),
                "pa_services" => $paServices,
                "diagnosis_code" => $patient->diagnosis_code,
                "insurer_id" => $patient->insurer_id, // el id interno del insuerer
                // "insuranceId" => $patient->insuranceId, // el id externo (o code) del insuerer
                "insurance_identifier" => $patient->insurance_identifier,
            ] : null
        ]);
    }

    //se obtiene el bip del usuario
    public function showbyUser($patient_identifier)
    {
        $bip = Bip::where("patient_identifier", $patient_identifier)->first();
        // $reduction_goal = ReductionGoal::where("patient_id", $patient_id)->first();


        return response()->json([
            "patient_identifier" => $bip->patient_identifier,
            // "bip" => $bip,
            "bip" => BipResource::make($bip),
            "type_of_assessment" => $bip->type_of_assessment,
            "documents_reviewed" =>
            is_string($bip->documents_reviewed)
                ? json_decode($bip->documents_reviewed)
                : $bip->documents_reviewed,
            "maladaptives" =>
            is_string($bip->maladaptives)
                ? json_decode($bip->maladaptives)
                : $bip->maladaptives,
            "assestment_conducted_options" =>
            is_string($bip->assestment_conducted_options)
                ? json_decode($bip->assestment_conducted_options)
                : $bip->assestment_conducted_options,
            "prevalent_setting_event_and_atecedents" =>
            is_string($bip->prevalent_setting_event_and_atecedents)
                ? json_decode($bip->prevalent_setting_event_and_atecedents)
                : $bip->prevalent_setting_event_and_atecedents,
            "interventions" =>
            is_string($bip->interventions)
                ? json_decode($bip->interventions)
                : $bip->interventions,
            "assestmentEvaluationSettings" =>
            is_string($bip->assestmentEvaluationSettings)
                ? json_decode($bip->assestmentEvaluationSettings)
                : $bip->assestmentEvaluationSettings,
            "tangibles" =>
            is_string($bip->tangibles)
                ? json_decode($bip->tangibles)
                : $bip->tangibles,
            "attention" =>
            is_string($bip->attention)
                ? json_decode($bip->attention)
                : $bip->attention,
            "escape" =>
            is_string($bip->escape)
                ? json_decode($bip->escape)
                : $bip->escape,
            "sensory" =>
            is_string($bip->sensory)
                ? json_decode($bip->sensory)
                : $bip->sensory,
            "phiysical_and_medical_status" =>
            is_string($bip->phiysical_and_medical_status)
                ? json_decode($bip->phiysical_and_medical_status)
                : $bip->phiysical_and_medical_status,
            // "consent_to_treatment"=>$bip->consent_to_treatment,


        ]);
    }
    public function showbyUserPatientId($patient_identifier)
    {
        $bip = Bip::where("patient_identifier", $patient_identifier)->first();
        $goalsmaladaptive = ReductionGoal::where("maladaptive", $bip->maladaptive)
            ->orderBy("id", "desc")->get();
        $reduction_goal = ReductionGoal::where("patient_identifier", $patient_identifier)->first();


        return response()->json([
            "id" => $bip->id,
            "bip" => $bip,
            "reduction_goal" => $reduction_goal,
            "goalsmaladaptive" => $goalsmaladaptive,
            "type_of_assessment" => $bip->type_of_assessment,
            "documents_reviewed" =>
            is_string($bip->documents_reviewed)
                ? json_decode($bip->documents_reviewed)
                : $bip->documents_reviewed,
            "maladaptives" =>
            is_string($bip->maladaptives)
                ? json_decode($bip->maladaptives)
                : $bip->maladaptives,
            "assestment_conducted_options" =>
            is_string($bip->assestment_conducted_options)
                ? json_decode($bip->assestment_conducted_options)
                : $bip->assestment_conducted_options,
            "assestmentEvaluationSettings" =>
            is_string($bip->assestmentEvaluationSettings)
                ? json_decode($bip->assestmentEvaluationSettings)
                : $bip->assestmentEvaluationSettings,
            "tangibles" =>
            is_string($bip->tangibles)
                ? json_decode($bip->tangibles)
                : $bip->tangibles,
            "attention" =>
            is_string($bip->attention)
                ? json_decode($bip->attention)
                : $bip->attention,
            "escape" =>
            is_string($bip->escape)
                ? json_decode($bip->escape)
                : $bip->escape,
            "sensory" =>
            is_string($bip->sensory)
                ? json_decode($bip->sensory)
                : $bip->sensory,
            "prevalent_setting_event_and_atecedents" =>
            is_string($bip->prevalent_setting_event_and_atecedents)
                ? json_decode($bip->prevalent_setting_event_and_atecedents)
                : $bip->prevalent_setting_event_and_atecedents,
            "phiysical_and_medical_status" =>
            is_string($bip->phiysical_and_medical_status)
                ? json_decode($bip->phiysical_and_medical_status)
                : $bip->phiysical_and_medical_status,
            "interventions" =>
            is_string($bip->interventions)
                ? json_decode($bip->interventions)
                : $bip->interventions,
        ]);
    }

    public function showBipPatientIdProfile($patient_identifier)
    {
        $bip = Bip::where("patient_identifier", $patient_identifier)->first();
        $reduction_goal = ReductionGoal::where("patient_identifier", $patient_identifier)->first();
        $patient = Patient::where("patient_identifier", $patient_identifier)->first();
        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found'
            ], 404);
        }

        $paServices = $this->getFormattedPaServices($patient_identifier);

        return response()->json([
            "id" => $bip->id,
            "maladaptives" =>
            is_string($bip->maladaptives)
                ? json_decode($bip->maladaptives)
                : $bip->maladaptives,
            "interventions" =>
            is_string($bip->interventions)
                ? json_decode($bip->interventions)
                : $bip->interventions,
            "reduction_goal" =>
            is_string($bip->reduction_goal)
                ? json_decode($bip->reduction_goal)
                : $bip->reduction_goal,
            "sustitution_goal" => $bip->sustitution_goal,
            "doctor_id" => $bip->doctor_id,
            "patient" => $patient->id ? [
                "id" => $patient->id,
                "patient_identifier" => $patient->patient_identifier,
                "location_id" => $patient->location_id,
                "first_name" => $patient->first_name,
                "last_name" => $patient->last_name,
                "birth_date" => $patient->birth_date,
                "diagnosis_code" => $patient->diagnosis_code,
                "pos_covered" =>
                is_string($patient->pos_covered)
                    ? json_decode($patient->pos_covered)
                    : $patient->pos_covered,
                "pa_assessments" => json_encode($paServices),
                "pa_services" => $paServices,
                "insurer_id" => $patient->insurer_id,
                // "insuranceId" => $patient->insuranceId,
                "insurance_identifier" => $patient->insurance_identifier,
            ] : null,
        ]);
    }

    public function showBipPatientIdProfilePdf($patient_identifier)
    {
        $bip = Bip::where("patient_identifier", $patient_identifier)->first();
        $reduction_goal = ReductionGoal::where("patient_identifier", $patient_identifier)->first();
        $patient = Patient::where("patient_identifier", $patient_identifier)->first();

        return response()->json([
            "bip" => BipResource::make($bip),
            "maladaptives" =>
            is_string($bip->maladaptives)
                ? json_decode($bip->maladaptives)
                : $bip->maladaptives,


            "patient" => $patient->id ? [
                "id" => $patient->id,
                "patient_identifier" => $patient->patient_identifier,
                "first_name" => $patient->first_name,
                "last_name" => $patient->last_name,
                "age" => $patient->age,
                "birth_date" => $patient->birth_date,
                "phone" => $patient->phone,
                // "avatar" => $patient->avatar ? env("APP_URL") . "storage/" . $patient->avatar : null,
                "avatar" => $patient->avatar ? env("APP_URL") .  $patient->avatar : null,

                "address" => $patient->address,
            ] : null,
        ]);
    }

    //filtro por  patientID o n_doc para busquedas y asiganciones al paciente
    public function query_patient(Request $request)
    {
        $patientID = $request->get("patientID");

        $patient = Patient::where("patientID", $patientID)->first();

        if (!$patient) {
            return response()->json([
                "message" => 403,
            ]);
        }

        return response()->json([
            "message" => 200,
            "id" => $patient->id,
            "first_name" => $patient->first_name,
            "last_name" => $patient->last_name,
            "phone" => $patient->phone,
            "patientID" => $patient->patientID,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $bip = Bip::findOrFail("id", $id)->first();
        // $bip_is_valid = Bip::where("id", "<>", $id)->first();


        $bip = Bip::findOrFail($id);

        $request->request->add(["documents_reviewed" => json_encode($request->documents_reviewed)]);
        $request->request->add(["maladaptives" => json_encode($request->maladaptives)]);
        $request->request->add(["assestment_conducted_options" => json_encode($request->assestment_conducted_options)]);
        $request->request->add(["assestmentEvaluationSettings" => json_encode($request->assestmentEvaluationSettings)]);
        $request->request->add(["tangibles" => json_encode($request->tangibles)]);
        $request->request->add(["attention" => json_encode($request->attention)]);
        $request->request->add(["escape" => json_encode($request->escape)]);
        $request->request->add(["sensory" => json_encode($request->sensory)]);
        $request->request->add(["phiysical_and_medical_status" => json_encode($request->phiysical_and_medical_status)]);
        $request->request->add(["prevalent_setting_event_and_atecedents" => json_encode($request->prevalent_setting_event_and_atecedents)]);
        $request->request->add(["interventions" => json_encode($request->interventions)]);

        $bip->update($request->all());

        return response()->json([
            "message" => 200,
            "bip" => $bip,
            "type_of_assessment" => $bip->type_of_assessment,
            "documents_reviewed" =>
            is_string($bip->documents_reviewed)
                ? json_decode($bip->documents_reviewed)
                : $bip->documents_reviewed,
            "maladaptives" =>
            is_string($bip->maladaptives)
                ? json_decode($bip->maladaptives)
                : $bip->maladaptives,
            "assestment_conducted_options" =>
            is_string($bip->assestment_conducted_options)
                ? json_decode($bip->assestment_conducted_options)
                : $bip->assestment_conducted_options,
            "assestmentEvaluationSettings" =>
            is_string($bip->assestmentEvaluationSettings)
                ? json_decode($bip->assestmentEvaluationSettings)
                : $bip->assestmentEvaluationSettings,
            "tangibles" =>
            is_string($bip->tangibles)
                ? json_decode($bip->tangibles)
                : $bip->tangibles,
            "attention" =>
            is_string($bip->attention)
                ? json_decode($bip->attention)
                : $bip->attention,
            "escape" =>
            is_string($bip->escape)
                ? json_decode($bip->escape)
                : $bip->escape,
            "sensory" =>
            is_string($bip->sensory)
                ? json_decode($bip->sensory)
                : $bip->sensory,
            "prevalent_setting_event_and_atecedents" =>
            is_string($bip->prevalent_setting_event_and_atecedents)
                ? json_decode($bip->prevalent_setting_event_and_atecedents)
                : $bip->prevalent_setting_event_and_atecedents,
            "phiysical_and_medical_status" =>
            is_string($bip->phiysical_and_medical_status)
                ? json_decode($bip->phiysical_and_medical_status)
                : $bip->phiysical_and_medical_status,
            "interventions" =>
            is_string($bip->interventions)
                ? json_decode($bip->interventions)
                : $bip->interventions,
        ]);
    }

    /**
     * Get formatted PA services for a patient
     *
     * @param string $patient_identifier
     * @return array
     */
    private function getFormattedPaServices($patient_identifier)
    {
        $patient = Patient::where("patient_identifier", $patient_identifier)->first();

        if (!$patient) {
            return [];
        }

        return $patient->paServices()
            ->get()
            ->map(function ($service) use ($patient_identifier) {
                return [
                    'id' => $service->id,
                    'pa_services' => $service->pa_services,
                    'cpt' => $service->cpt,
                    'n_units' => $service->n_units,
                    'available_units' => $service->available_units,
                    'spent_units' => $service->spent_units,
                    'start_date' => $service->start_date->format('Y-m-d'),
                    'end_date' => $service->end_date->format('Y-m-d'),
                ];
            })
            ->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
