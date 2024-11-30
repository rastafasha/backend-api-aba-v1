<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Models\Insurance\Insurance;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Patient\PatientResource;
use App\Http\Resources\Patient\PatientCollection;
use App\Http\Resources\Location\LocationCollection;
use App\Http\Resources\Insurance\InsuranceCollection;

class ClientLogReporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $specialists = User::where("status", 'active')->get();

        $role_rbt = User::orderBy("id", "desc")
        ->whereHas("roles", function ($q) {
            $q->where("name", "like", "%RBT%");
        })
        ->get();
        $role_bcba = User::orderBy("id", "desc")
        ->whereHas("roles", function ($q) {
            $q->where("name", "like", "%BCBA%");
        })
        ->get();
        $role_admin = User::orderBy("id", "desc")
        ->whereHas("roles", function ($q) {
            $q->where("name", "like", "%ADMIN%");
        })
        ->get();
        $role_manager = User::orderBy("id", "desc")
        ->whereHas("roles", function ($q) {
            $q->where("name", "like", "%MANAGER%");
        })
        ->get();
        $role_superadmin = User::orderBy("id", "desc")
        ->whereHas("roles", function ($q) {
            $q->where("name", "like", "%SUPERADMIN%");
        })
        ->get();

        // filtro buscador
        $patient_identifier = $request->patient_identifier;
        $name_patient = $request->search;
        $email_patient = $request->search;
        $status = $request->status;
        $rbt_home = $request->rbt_home;
        $rbt2_school = $request->rbt2_school;
        $bcba_home = $request->bcba_home;
        $bcba2_school = $request->bcba2_school;
        $clin_director = $request->clin_director;
        // $date = $request->date;

        $patients = Patient::filterAdvanceClientlog(
            $patient_identifier,
            $name_patient,
            $email_patient,
            $status,
            $rbt_home,
            $rbt2_school,
            $bcba_home,
            $bcba2_school,
            $clin_director,
        )->orderBy("id", "desc")
                            ->paginate(10);

        //fin  filtro buscador

        $insurances = Insurance::get();
        $locations = Location::get();
        $local = Patient::where('location_id', '<>', 'id')->get();
        $patients = Patient::orderBy('id', 'desc')->get();
        $manager = User::where('location_id', 1)->get();

        $pa_assessmentsCollection = collect();


        // Initialize an empty array to store the JSON strings
        $json_strings = [];

        foreach ($patients as $item) {
            // Log::debug("Processing item: ". $item);

            $pa_assessmentsCollection->push($item->pa_assessments);
            Log::debug("pa_assessmentsCollection: " . $pa_assessmentsCollection);

            $json_string = str_replace(['[{\"\\\"[', '\\\\\\"',  ']\\\"\"],'], ['[', '\"',  '"]'], $item->pa_assessments);
            // Log::debug("Cleaned JSON string: ". $json_string);

            // Validate JSON string
            $json_error = json_last_error();
            if ($json_error !== JSON_ERROR_NONE) {
                $json_error_message = json_last_error_msg();
                Log::debug("Invalid JSON string: " . $json_error_message);
                continue;
            }

            // Decode JSON string
            $pa_assessments = json_decode($json_string, false, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            if (!is_array($pa_assessments)) {
                Log::debug("Failed to decode JSON: " . json_last_error_msg());
                continue;
            }

            // Process the decoded JSON
            foreach ($pa_assessments as $pa_assessment) {
                $pa_assessment = $pa_assessment->pa_assessment;
                $pa_assessment_start_date = $pa_assessment->pa_assessment_start_date;
                $pa_assessment_end_date = $pa_assessment->pa_assessment_end_date;
                $pa_services = $pa_assessment->pa_services;
                $pa_services_start_date = $pa_assessment->pa_services_start_date;
                $pa_services_end_date = $pa_assessment->pa_services_end_date;
                $cpt = $pa_assessment->cpt;
                $n_units = $pa_assessment->n_units;
            }
        }


        return response()->json([
            // "total"=>$patients->total(),
            "patients" => $patients,
            // "patients" => PatientCollection::make($patients),
            "patients" => $patients->map(function ($patient) {
                return[

                    "id" => $patient->id,
                    "patient_identifier" => $patient->patient_identifier,
                    "first_name" => $patient->first_name,
                    "last_name" => $patient->last_name,
                    "full_name" => $patient->first_name . ' ' . $patient->last_name,
                    "email" => $patient->email,
                    "phone" => $patient->phone,
                    "avatar" => $patient->avatar ? env("APP_URL") . "storage/" . $patient->avatar : null,
                    // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
                    "birth_date" => $patient->birth_date ? Carbon::parse($patient->birth_date)->format("Y/m/d") : null,
                    "gender" => $patient->gender,
                    "address" => $patient->address,
                    "language" => $patient->language,
                    "home_phone" => $patient->home_phone,
                    "work_phone" => $patient->work_phone,
                    "zip" => $patient->zip,
                    "city" => $patient->city,
                    "relationship" => $patient->relationship,
                    "profession" => $patient->profession,
                    "education" => $patient->education,
                    "state" => $patient->state,
                    "school_name" => $patient->school_name,
                    "school_number" => $patient->school_number,
                    "age" => $patient->age,
                    "parent_guardian_name" => $patient->parent_guardian_name,
                    "schedule" => $patient->schedule,
                    "summer_schedule" => $patient->summer_schedule,
                    "diagnosis_code" => $patient->diagnosis_code,
                    "special_note" => $patient->special_note,
                    "patient_control" => $patient->patient_control,

                    //benefits
                    "insurer_id" => $patient->insurer_id,


                    'insurances' => $patient-> insurances,
                        'insurances' => [
                            // 'id'=> $patient->insurances->insurer_id,
                            'name' => $patient->insurances->name,
                            'notes' => json_decode($patient->insurances-> notes) ? : null,
                            'services' => json_decode($patient->insurances-> services) ? : null,
                        ],


                    "status" => $patient->status,
                    "insuranceId" => $patient->insuranceId,
                    "elegibility_date" => $patient->elegibility_date ? Carbon::parse($patient->elegibility_date)->format("Y/m/d") : null,
                    "pos_covered" => $patient->pos_covered ,
                    // "pos_covered" => json_decode($patient->pos_covered) ? : null,
                    "deductible_individual_I_F" => $patient->deductible_individual_I_F,
                    "balance" => $patient->balance,
                    "coinsurance" => $patient->coinsurance,
                    "copayments" => $patient->copayments,
                    "oop" => $patient->oop,

                    //intake
                    "welcome" => $patient->welcome,
                    "consent" => $patient->consent,
                    "insurance_card" => $patient->insurance_card,
                    "eligibility" => $patient->eligibility,
                    "mnl" => $patient->mnl,
                    "referral" => $patient->referral,
                    "ados" => $patient->ados,
                    "iep" => $patient->iep,
                    "asd_diagnosis" => $patient->asd_diagnosis,
                    "cde" => $patient->cde,
                    "submitted" => $patient->submitted,
                    "interview" => $patient->interview,
                    "eqhlid" => $patient->eqhlid,
                    "telehealth" => $patient->telehealth,
                    "pay" => $patient->pay,

                    //pas
                    // 'pa_assessments'=> json_decode(str_replace('{\\', '', $patient->pa_assessments)),
                    // 'pa_assessments' => json_decode($patient->pa_assessments),


                    "location_id" => $patient->location_id,
                    'locals' => $patient-> locals,
                        'locals' => [
                            'title' => $patient->locals->title,
                            "address" => $patient->locals->address,
                            "phone1" => $patient->locals->phone1,
                            "phone2" => $patient->locals->phone2,
                            "email" => $patient->locals->email,
                            "city" => $patient->locals->city,
                            "state" => $patient->locals->state,
                            "zip" => $patient->locals->zip,
                        ],

                    "manager" => $patient->manager,

                    "rbt_home_id" => $patient->rbt_home_id,
                    'rbt_home' => $patient-> rbt_home,
                        'rbt_home' => [
                            // 'id'=> $patient->rbt_home->rbt_home_id,
                            'name' => $patient->rbt_home->name,
                            'surname' => $patient->rbt_home->surname,
                            'npi' => $patient->rbt_home->npi,
                        ],

                    "rbt2_school_id" => $patient->rbt2_school_id,
                    'rbt2_school' => $patient-> rbt2_school,
                        'rbt2_school' => [
                            // 'id'=> $patient->rbt2_school->rbt2_school_id,
                            'name' => $patient->rbt2_school->name,
                            'surname' => $patient->rbt2_school->surname,
                            'npi' => $patient->rbt2_school->npi,
                        ],
                    "bcba_home_id" => $patient->bcba_home_id,
                    'bcba_home' => $patient-> bcba_home,
                        'bcba_home' => [
                            // 'id'=> $patient->bcba_home->bcba_home_id,
                            'name' => $patient->bcba_home->name,
                            'surname' => $patient->bcba_home->surname,
                            'npi' => $patient->bcba_home->npi,
                        ],
                    "bcba2_school_id" => $patient->bcba2_school_id,
                    'bcba2_school' => $patient-> bcba2_school,
                        'bcba2_school' => [
                            // 'id'=> $patient->bcba2_school->bcba2_school_id,
                            'name' => $patient->bcba2_school->name,
                            'surname' => $patient->bcba2_school->surname,
                            'npi' => $patient->bcba2_school->npi,
                        ],
                    "clin_director_id" => $patient->clin_director_id,
                    'clin_director' => $patient-> clin_director,
                        'clin_director' => [
                            // 'id'=> $patient->clin_director->clin_director_id,
                            'name' => $patient->clin_director->name,
                            'surname' => $patient->clin_director->surname,
                            "avatar" => $patient->clin_director->avatar ? env("APP_URL") . "storage/" . $patient->clin_director->avatar : null,
                            // "avatar"=> $patient->clin_director->avatar ? env("APP_URL").$patient->clin_director->avatar : null,
                            'npi' => $patient->clin_director->npi,
                        ],


                    "created_at" => $patient->created_at ? Carbon::parse($patient->created_at)->format("Y-m-d h:i A") : null,
                ];
            }),



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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
