<?php

namespace App\Http\Controllers\Patient;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Billing;
use App\Models\Bip\Bip;
use App\Models\Location;
use App\Models\Bip\BipFile;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Insurance\Insurance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use App\Models\Patient\PatientPerson;
use App\Models\Appointment\Appointment;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Patient\PatientResource;
use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Patient\PatientCollection;
use App\Http\Resources\Insurance\InsuranceCollection;
use App\Http\Resources\Appointment\AppointmentCollection;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $search = $request->search;
    //     $email_patient = $request->search;
    //     $state = $request->state;

    //     $patients = Patient::where(DB::raw("CONCAT(patients.first_name,' ', IFNULL(patients.last_name,''),' ',patients.email)"),
    //     "like","%".$search."%"
    //     )->orderBy("id", "desc")
    //     ->paginate(20);
                    
    //     return response()->json([
    //         "total" =>$patients->total(),
    //         "patients" => PatientCollection::make($patients),
            
    //     ]);          
    // }

    public function index(Request $request)
    {
        $patient_id = $request->patient_id;
        $name_patient = $request->search;
        $email_patient = $request->search;
        $status = $request->status;
        $location_id = $request->location_id;
        // $date = $request->date;

        // $bip = Bip::findOrFail($patient_id);

        $patients = Patient::filterAdvancePatient($patient_id, $name_patient, $email_patient, $status,$location_id)->orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            // "total"=>$patients->total(),
            // "patients"=> $patients,
            // "bip"=> $bip,
            "patients"=> PatientCollection::make($patients),
            // "patients"=>$patients->map(function($patient){
            //     return [
            //         "id"=> $patient->id,
            //         "full_name"=> $patient->full_name,
            //         "name"=> $patient->name,
            //         "surname"=> $patient->surname,
            //         "avatar"=> $patient->avatar,
            //         "location_id"=> $patient->location_id,
            //         "patient_id"=> $patient->patient_id,
            //         "phone"=> $patient->phone,
            //         "email"=> $patient->email,
            //         "status"=> $patient->status,
            //         "city"=> $patient->city,
            //         "created_at"=> $patient->created_at,
                    
            //     ];
            // }),
            
            
        ]);

    }

    public function patientsByDoctor(Request $request, $doctor_id)
    {

        $doctor_is_valid = User::where("id", $request->doctor_id)->first();
        


        // $patientRbts = Patient::where("rbt_id", $request->doctor_id)->orderBy("id", "desc")->paginate(10);
        $patients = Patient::Where('rbt_home_id', $doctor_id)
                ->orWhere('rbt2_school_id', $doctor_id)
                ->orWhere('bcba_home_id', $doctor_id)
                ->orWhere('bcba2_school_id', $doctor_id)
                ->orWhere('clin_director_id', $doctor_id)
                ->get();

        return response()->json([
            // "patients"=> $patients,
            // "total"=>$patients->total(),
            "patients"=> PatientCollection::make($patients)
            // "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : [],
        ]);

    }

    public function config($location_id)
    {
        $location = Location::where('id',$location_id)->first();
        $locations = Location::get();
        $insurances = Insurance::get();

        $doctores= UserLocation::where("location_id",'=', $location_id)
        ->get();
        
        // $user = UserLocation::where('location_id',"=",$location_id)
        // ->where('user_id',"=",$location->user_id)
        // ->get();
        
        //esta es la funcion con la tabla aparte del multilocation


        $users = User::whereHas('locations', function ($query) use ($location_id) {
            $query->where('location_id', $location_id);
        })->get();

        
        // $role_rbt= UserLocation::orderBy("id", "desc")
        // ->whereHas("locals", function($q)
        // {
        //     $q->where("location_id",'=', $location_id);
        //     })
        //     ->whereHas("roles", function($q){
        //         $q->where("name","like","%RBT%");
        //         })
        //         ->get(['id','name', 'surname', 'status']);

        

       
        
        
        return response()->json([
            // "user" => $user,
            // "users" => UserCollection::make($users),
            "users"=>$users->map(function($user){
                return[
                    "id"=> $user->id,
                    "full_name"=> $user->name.' '. $user->surname,
                    "status"=> $user->status,
                    "roles"=> $user->roles,
                    
                ];
            }),
            "doctores" => UserCollection::make($doctores),
             "doctores"=>$doctores->map(function($doctor){
                return[
                    "location_id"=> $doctor->location_id,
                    "user_id"=> $doctor->user_id,
                    
                ];
            }),
             "location" => $location,
            "locations" => $locations,
            "insurances" => $insurances,
            
        ]);
    }
    

    // public function configLocation($location_id)
    // {
    //     // $patient= Patient::where("patient_id")->first();
    //     // $roles = Role::where("name","like","%DOCTOR%")->get();
    //     $specialists = User::
    //     where("status",'active')
    //     ->where('location_id',$location_id)
    //     ->get(['id','name', 'surname', 'status']);

    //     $role_bcba= User::orderBy("id", "desc")
    //     ->whereHas("roles", function($q){
    //         $q->where("name","like","%BCBA%");
    //     })
    //     ->where('location_id',$location_id)
    //     ->get(['id','name', 'surname', 'status']);

    //     $role_admin= User::orderBy("id", "desc")
    //     ->whereHas("roles", function($q){
    //         $q->where("name","like","%ADMIN%");
    //     })
    //     ->where('location_id',$location_id)
    //     ->get(['id','name', 'surname', 'status']);
        
    //     $role_superadmin= User::orderBy("id", "desc")
    //     ->whereHas("roles", function($q){
    //         $q->where("name","like","%SUPERADMIN%");
    //     })
    //     ->where('location_id',$location_id)
    //     ->get(['id','name', 'surname', 'status']);

    //     $role_manager= User::orderBy("id", "desc")
    //     ->whereHas("roles", function($q){
    //         $q->where("name","like","%MANAGER%");
    //     })
    //     ->where('location_id',$location_id)
    //     ->get(['id','name', 'surname', 'status']);

    //     $insurances = Insurance::get();
    //     $locations = Location::get();
    //     $location = Location::where('id',$location_id)->first();
        
        
    //     return response()->json([
    //         "roles_rbt" => $role_rbt,
            
    //         "insurances" => $insurances,
    //         "roles_bcba" => $role_bcba,
    //         "specialists" => $specialists,
    //         // "insurances" => InsuranceCollection::make($insurances),//trae el json convertido para manipular
    //         "location" => $location,
    //         "locations" => $locations,
    //         "roles_admin" => $role_admin,
    //         "roles_manager" => $role_manager,
    //         "roles_superadmin" => $role_superadmin,
    //         // "documents" => $documents,
            
    //     ]);
    // }

   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        
        $patient = Patient::findOrFail($id);
        $specialists = User::where("status",'active')->get();
        $insurances = Insurance::get();
        $locations = Location::get();


        return response()->json([
            // "patient" => $patient,
            "patient"=> PatientResource::make($patient),
            "specialists" => $specialists,
            "insurances" => $insurances,
            "locations" => $locations,
            "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : [],
            
            // "patient" => PatientResource::make($patient),
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
        $patient_is_valid = Patient::where("patient_id", $request->patient_id)->first();

        $request->request->add(["pa_assessments"=>json_encode($request->pa_assessments)]);
        $request->request->add(["pos_covered"=>json_encode($request->pos_covered)]);
        // $request->request->add(["pa_services"=>json_encode($request->services)]);

        if($patient_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'the user with this email already exist'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:patients',
            // ...
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("patients", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        if($request->birth_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->birth_date );
            $request->request->add(["birth_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        if($request->pa_assessment_start_date){
            $date_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_assessment_start_date );
            $request->request->add(["pa_assessment_start_date" => Carbon::parse($date_clean1)->format('Y-m-d h:i:s')]);
        }

        if($request->pa_assessment_end_date){
            $date_clean2 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_assessment_end_date );
            $request->request->add(["pa_assessment_end_date" => Carbon::parse($date_clean2)->format('Y-m-d h:i:s')]);
        }
        
        if($request->pa_services_start_date){
            $date_clean3 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_services_start_date );
            $request->request->add(["pa_services_start_date" => Carbon::parse($date_clean3)->format('Y-m-d h:i:s')]);
        }
        
        if($request->pa_services_end_date){
            $date_clean4 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_services_end_date );
            $request->request->add(["pa_services_end_date" => Carbon::parse($date_clean4)->format('Y-m-d h:i:s')]);
        }
        if($request->elegibility_date){
            $date_clean5 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->elegibility_date );
            $request->request->add(["elegibility_date" => Carbon::parse($date_clean5)->format('Y-m-d h:i:s')]);
        }
        
        $patient = Patient::create($request->all());


        // $billing = Billing::create([
        //     "patient_id" => $request->patient_id,
        //     "sponsor_id" => $request->doctor_id,
        //     "insurer_id" => $request->insurer_id,
            
        // ]);
        
        
        // $request->request->add([
        //     "client_id" =>$patient->id
        // ]);

        return response()->json([
            "message"=>200,
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
        $patient = Patient::findOrFail($id);

        return response()->json([
            "patient" => PatientResource::make($patient),
            "pa_assessments"=>json_decode($patient->pa_assessments) ? : null,
            "pos_covered"=>json_decode($patient->pos_covered) ? : null,
        ]);
    }

    public function showPatientId($patient_id)
    {

        $doctors = Patient::join('users', 'patients.id', '=', 'users.id')
        ->select(
            
            'patients.id as id',
            'users.name',
            )
        ->get();
        
        
        $patient = Patient::where('patient_id',$patient_id)->first();

        return response()->json([
            
            "patient" => $patient,
            "patient"=> $patient ?[
                "id" =>$patient->id,
                "title"=>$patient->patient_id,
                "full_name"=> $patient->first_name.' '.$patient->last_name,
                "email"=>$patient->email,
                "insurer_id"=>$patient->insurer_id,
                "rbt_home" =>$patient->rbt_home_id,
                "rbt2_school"=>$patient->rbt2_school_id,
                "bcba_home"=>$patient->bcba_home_id,
                "bcba2_school"=>$patient->bcba2_school_id,
                "clin_director_id"=>$patient->clin_director_id,
                "status"=>$patient->status,
                "gender"=>$patient->gender,
                "avatar"=> $patient->avatar ? env("APP_URL")."storage/".$patient->avatar : null,
            // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
            ]:null,
            "doctors" => $doctors,
            
        ]);
    }


    public function showPatientbyLocation($location_id)
    {

        // $doctors = Patient::join('users', 'patients.id', '=', 'users.id')
        // ->where('location_id',$location_id)
        // ->select(
            
        //     'patients.id as id',
        //     'users.name',
        //     'users.surname',
        //     'users.location_id',
        //     )
        // ->get();
        
        
        $doctors = User::where('location_id',$location_id)->get();
        $patients = Patient::where('location_id',$location_id)->get();

        return response()->json([
            
            "patients" => $patients,
            "patients" => PatientCollection::make($patients),
            // "patients"=>$patients->map(function($patient){
            //     return[
            //         // "cpt_code"=> $noteBcba->cpt_code,
            //         // 'tecnico'=>$noteBcba-> tecnico,
            //         // 'tecnico'=>[
            //         //     'name'=> $noteBcba->tecnico->name,
            //         //     'surname'=> $noteBcba->tecnico->surname,
            //         //     'npi'=> $noteBcba->tecnico->npi,
            //         // ],
            //         "id"=>$patient->id,
            //         "patient_id"=>$patient->patient_id,    
            //         "first_name"=>$patient->first_name,
            //         "last_name"=>$patient->last_name,
            //         "full_name"=> $patient->first_name.' '.$patient->last_name,
            //         "email"=>$patient->email,
            //         "phone"=>$patient->phone,
            //         "avatar"=> $patient->avatar ? env("APP_URL")."storage/".$patient->avatar : null,
            //         // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
            //         "birth_date"=>$patient->birth_date ? Carbon::parse($patient->birth_date)->format("Y/m/d") : NULL,
            //         "gender"=>$patient->gender,
            //         "address"=>$patient->address,
            //         "language"=>$patient->language,
            //         "home_phone"=>$patient->home_phone,
            //         "work_phone"=>$patient->work_phone,
            //         "zip"=>$patient->zip,
            //         "city"=>$patient->city,
            //         "relationship"=>$patient->relationship,
            //         "profession"=>$patient->profession,
            //         "education"=>$patient->education,
            //         "state"=>$patient->state,
            //         "school_name"=>$patient->school_name,
            //         "school_number"=>$patient->school_number,
            //         "age"=>$patient->age,
            //         "parent_guardian_name"=>$patient->parent_guardian_name,
            //         "schedule"=>$patient->schedule,
            //         "summer_schedule"=>$patient->summer_schedule,
            //         "diagnosis_code"=>$patient->diagnosis_code,
            //         "special_note"=>$patient->special_note,
            //         "patient_control"=>$patient->patient_control,
                    
            //         //benefits
            //         "insurer_id"=>$patient->insurer_id,
                    

            //         'insurances'=>$patient-> insurances,
            //             'insurances'=>[
            //                 // 'id'=> $patient->insurances->insurer_id,
            //                 'insurer_name'=> $patient->insurances->insurer_name,
            //                 'notes'=> json_decode($patient->insurances-> notes)? : null,
            //                 'services'=> json_decode($patient->insurances-> services)? : null,
            //             ],


            //         "status"=>$patient->status,
            //         "insuranceId"=>$patient->insuranceId,
            //         // "insurer_secundary"=>$patient->insurer_secundary,          
            //         // "insuranceId_secundary"=>$patient->insuranceId_secundary,          
            //         "elegibility_date"=>$patient->elegibility_date ? Carbon::parse($patient->elegibility_date)->format("Y/m/d") : NULL,
            //         // "pos_covered"=>$patient->pos_covered ,
            //         "pos_covered"=> json_decode($patient->pos_covered)? : null,
            //         "deductible_individual_I_F"=>$patient->deductible_individual_I_F,
            //         "balance"=>$patient->balance,
            //         "coinsurance"=>$patient->coinsurance,
            //         "copayments"=>$patient->copayments,
            //         "oop"=>$patient->oop,
                    
            //         //intake
            //         "welcome"=>$patient->welcome,
            //         "consent"=>$patient->consent,
            //         "insurance_card"=>$patient->insurance_card,
            //         "eligibility"=>$patient->eligibility,
            //         "mnl"=>$patient->mnl,
            //         "referral"=>$patient->referral,
            //         "ados"=>$patient->ados,
            //         "iep"=>$patient->iep,
            //         "asd_diagnosis"=>$patient->asd_diagnosis,
            //         "cde"=>$patient->cde,
            //         "submitted"=>$patient->submitted,
            //         "interview"=>$patient->interview,
            //         "eqhlid"=>$patient->eqhlid,
            //         "telehealth"=>$patient->telehealth,
            //         "pay"=>$patient->pay,
                    
            //         //pas
            //         'pa_assessments'=> json_decode($patient->pa_assessments) ? : null,
            //         // "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : [],

            //         // "location" =>implode($patient->location_id),
            //         "location_id" =>$patient->location_id,
            //         "manager" =>$patient->manager,

            //         "rbt_home_id" =>$patient->rbt_home_id,
            //         'rbt_home'=>$patient-> rbt_home,
            //             'rbt_home'=>[
            //                 // 'id'=> $patient->rbt_home->rbt_home_id,
            //                 'name'=> $patient->rbt_home->name,
            //                 'surname'=> $patient->rbt_home->surname,
            //                 'npi'=> $patient->rbt_home->npi,
            //             ],

            //         "rbt2_school_id"=>$patient->rbt2_school_id,
            //         'rbt2_school'=>$patient-> rbt2_school,
            //             'rbt2_school'=>[
            //                 // 'id'=> $patient->rbt2_school->rbt2_school_id,
            //                 'name'=> $patient->rbt2_school->name,
            //                 'surname'=> $patient->rbt2_school->surname,
            //                 'npi'=> $patient->rbt2_school->npi,
            //             ],
            //         "bcba_home_id"=>$patient->bcba_home_id,
            //         'bcba_home'=>$patient-> bcba_home,
            //             'bcba_home'=>[
            //                 // 'id'=> $patient->bcba_home->bcba_home_id,
            //                 'name'=> $patient->bcba_home->name,
            //                 'surname'=> $patient->bcba_home->surname,
            //                 'npi'=> $patient->bcba_home->npi,
            //             ],
            //         "bcba2_school_id"=>$patient->bcba2_school_id,
            //         'bcba2_school'=>$patient-> bcba2_school,
            //             'bcba2_school'=>[
            //                 // 'id'=> $patient->bcba2_school->bcba2_school_id,
            //                 'name'=> $patient->bcba2_school->name,
            //                 'surname'=> $patient->bcba2_school->surname,
            //                 'npi'=> $patient->bcba2_school->npi,
            //             ],
            //         "clin_director_id"=>$patient->clin_director_id,
            //         'clin_director'=>$patient-> clin_director,
            //             'clin_director'=>[
            //                 // 'id'=> $patient->clin_director->clin_director_id,
            //                 'name'=> $patient->clin_director->name,
            //                 'surname'=> $patient->clin_director->surname,
            //                 'npi'=> $patient->clin_director->npi,
            //             ],
                            
                    
            //     "created_at"=>$patient->created_at ? Carbon::parse($patient->created_at)->format("Y-m-d h:i A") : NULL,
            //     ];
            // }),
            
            "doctors" => $doctors,
            // "doctors" => UserCollection::make($doctors),
            // "doctors"=>$doctors->map(function($doctor){
            //     return[
            //         // "cpt_code"=> $noteBcba->cpt_code,

            //         "rbt_home_id" =>$doctor->rbt_home_id,
            //         'rbt_home'=>$doctor-> rbt_home,
            //             'rbt_home'=>[
            //                 // 'id'=> $doctor->rbt_home->rbt_home_id,
            //                 'name'=> $doctor->rbt_home->name,
            //                 'surname'=> $doctor->rbt_home->surname,
            //                 'npi'=> $doctor->rbt_home->npi,
            //                 'location_id'=> $doctor->clin_director->location_id,
            //             ],

            //         "rbt2_school_id"=>$doctor->rbt2_school_id,
            //         'rbt2_school'=>$doctor-> rbt2_school,
            //             'rbt2_school'=>[
            //                 // 'id'=> $doctor->rbt2_school->rbt2_school_id,
            //                 'name'=> $doctor->rbt2_school->name,
            //                 'surname'=> $doctor->rbt2_school->surname,
            //                 'npi'=> $doctor->rbt2_school->npi,
            //                 'location_id'=> $doctor->clin_director->location_id,
            //             ],
            //         "bcba_home_id"=>$doctor->bcba_home_id,
            //         'bcba_home'=>$doctor-> bcba_home,
            //             'bcba_home'=>[
            //                 // 'id'=> $doctor->bcba_home->bcba_home_id,
            //                 'name'=> $doctor->bcba_home->name,
            //                 'surname'=> $doctor->bcba_home->surname,
            //                 'npi'=> $doctor->bcba_home->npi,
            //                 'location_id'=> $doctor->clin_director->location_id,
            //             ],
            //         "bcba2_school_id"=>$doctor->bcba2_school_id,
            //         'bcba2_school'=>$doctor-> bcba2_school,
            //             'bcba2_school'=>[
            //                 // 'id'=> $doctor->bcba2_school->bcba2_school_id,
            //                 'name'=> $doctor->bcba2_school->name,
            //                 'surname'=> $doctor->bcba2_school->surname,
            //                 'npi'=> $doctor->bcba2_school->npi,
            //                 'location_id'=> $doctor->clin_director->location_id,
            //             ],
            //         "clin_director_id"=>$doctor->clin_director_id,
            //         'clin_director'=>$doctor-> clin_director,
            //             'clin_director'=>[
            //                 // 'id'=> $doctor->clin_director->clin_director_id,
            //                 'name'=> $doctor->clin_director->name,
            //                 'surname'=> $doctor->clin_director->surname,
            //                 'npi'=> $doctor->clin_director->npi,
            //                 'location_id'=> $doctor->clin_director->location_id,
            //             ],
            //    ];
            // }),
            
            
        ]);
    }

    public function emailExist(Request $request, $email)
    {
        $email = $request->input('email');
        $exists = Patient::where("email", $request->email)->first();
        if ($exists) {
            return response()->json([
                'exist' => [
                    'email' => $exists->email,
                ]
            ]);
        } else {
            return response()->json([
                'exist' => [
                    'email' => null,
                ]
            ]);
        }
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

        
        $patient_is_valid = Patient::where("id", "<>", $id)->first();
        
        // $request->request->add(["pa_services"=>json_encode($request->services)]);
        $request->request->add(["pa_assessments"=>json_encode($request->pa_assessments)]);
        $request->request->add(["pos_covered"=>json_encode($request->pos_covered)]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:patients',
            // ...
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        
        $patient = Patient::findOrFail($id);

        if($request->hasFile('imagen')){
            if($patient->avatar){
                Storage::delete($patient->avatar);
            }
            $path = Storage::putFile("patients", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        if($request->birth_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->birth_date );
            $request->request->add(["birth_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        if($request->pa_assessment_start_date){
            $date_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_assessment_start_date );
            $request->request->add(["pa_assessment_start_date" => Carbon::parse($date_clean1)->format('Y-m-d h:i:s')]);
        }

        if($request->pa_assessment_end_date){
            $date_clean2 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_assessment_end_date );
            $request->request->add(["pa_assessment_end_date" => Carbon::parse($date_clean2)->format('Y-m-d h:i:s')]);
        }
        
        if($request->pa_services_start_date){
            $date_clean3 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_services_start_date );
            $request->request->add(["pa_services_start_date" => Carbon::parse($date_clean3)->format('Y-m-d h:i:s')]);
        }
        
        if($request->pa_services_end_date){
            $date_clean4 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_services_end_date );
            $request->request->add(["pa_services_end_date" => Carbon::parse($date_clean4)->format('Y-m-d h:i:s')]);
        }
        if($request->elegibility_date){
            $date_clean5 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->elegibility_date );
            $request->request->add(["elegibility_date" => Carbon::parse($date_clean5)->format('Y-m-d h:i:s')]);
        }
       
        $patient->update($request->all());
        
        // error_log($patient);

        // if($patient->person){
        //     $patient->person->update($request->all());
        // }
        return response()->json([
            "message"=>200,
            "patient"=>$patient,
            "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : [],
            "pa_assessments"=>$patient->pos_covered ? json_decode($patient->pos_covered) : [],
        ]);
    }

    public function patientUpdate(Request $request, Patient $patient)
    {
        

        try {
            DB::beginTransaction();

            $input = $this->userInput($patient);
            $request->request->add(["pa_services"=>json_encode($request->services)]);
            $request->request->add(["pa_assessments"=>json_encode($request->pa_assessments)]);
            $request->request->add(["pos_covered"=>json_encode($request->pos_covered)]);
            if($request->hasFile('imagen')){
                if($patient->avatar){
                    Storage::delete($patient->avatar);
                }
                $path = Storage::putFile("patients", $request->file('imagen'));
                $request->request->add(["avatar"=>$path]);
            }
        
        if($request->birth_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->birth_date );
            $request->request->add(["birth_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        if($request->pa_assessment_start_date){
            $date_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_assessment_start_date );
            $request->request->add(["pa_assessment_start_date" => Carbon::parse($date_clean1)->format('Y-m-d h:i:s')]);
        }

        if($request->pa_assessment_end_date){
            $date_clean2 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_assessment_end_date );
            $request->request->add(["pa_assessment_end_date" => Carbon::parse($date_clean2)->format('Y-m-d h:i:s')]);
        }
        
        if($request->pa_services_start_date){
            $date_clean3 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_services_start_date );
            $request->request->add(["pa_services_start_date" => Carbon::parse($date_clean3)->format('Y-m-d h:i:s')]);
        }
        
        if($request->pa_services_end_date){
            $date_clean4 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->pa_services_end_date );
            $request->request->add(["pa_services_end_date" => Carbon::parse($date_clean4)->format('Y-m-d h:i:s')]);
        }
        if($request->elegibility_date){
            $date_clean5 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->elegibility_date );
            $request->request->add(["elegibility_date" => Carbon::parse($date_clean5)->format('Y-m-d h:i:s')]);
        }
            $patient->update($request->all());;

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Update user success',
                'user' => $user,
            ], 200);
        } catch (\Throwable $exception) {

            DB::rollBack();
            return response()->json([
                'message' => 'Error no update' . $exception,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        if($patient->avatar){
            Storage::delete($patient->avatar);
        }
        $patient->delete();
        return response()->json([
            "message"=>200
        ]);
    }

    public function updateEligibility(Request $request, $id)
    {
        $patient = Patient::findOrfail($id);
        $patient->status = $request->status;
        $patient->update();
        return $patient;
        
    }

}