<?php

namespace App\Http\Controllers\Admin\Notes;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use App\Models\Bip\FamilyEnvolment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Bip\MonitoringEvaluating;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Note\NoteBcbaResource;
use App\Http\Resources\Note\NoteBcbaCollection;
use App\Http\Resources\Bip\FamilyEnvolmentGoalsCollection;
use App\Http\Resources\Bip\MonitoringEvaluatingCollection;

class NoteBcbaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $note_bcbas = NoteBcba::orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            // "total"=>$patients->total(),
            "note_bcbas"=> NoteBcbaCollection::make($note_bcbas)
        ]);
    }

    public function config()
    {
        $specialists = User::where("status",'active')->get();

        $role_rbt= User::orderBy("id", "desc")
        ->whereHas("roles", function($q){
            $q->where("name","like","%RBT%");
        })->get();
        $role_bcba= User::orderBy("id", "desc")
        ->whereHas("roles", function($q){
            $q->where("name","like","%BCBA%");
        })->get();

        return response()->json([
            // "specialists" => $specialists,
            // "roles_rbt" => $role_rbt,
            // "roles_bcba" => $role_bcba,
            "specialists" => UserCollection::make($specialists),
             "specialists"=>$specialists->map(function($specialist){
                return[
                    // "location_id"=> $specialist->location_id,
                    "id"=> $specialist->id,
                    "avatar"=> $specialist->avatar,
                    "electronic_signature"=> $specialist->electronic_signature,
                    "name"=> $specialist->name,
                    "surname"=> $specialist->surname,
                    
                ];
            }),
            

            "roles_rbt" => UserCollection::make($role_rbt),
             "roles_rbt"=>$role_rbt->map(function($rol_rbt){
                return[
                    // "location_id"=> $rol_rbt->location_id,
                    "id"=> $rol_rbt->id,
                    "avatar"=> $rol_rbt->avatar,
                    "electronic_signature"=> $rol_rbt->electronic_signature,
                    "name"=> $rol_rbt->name,
                    "surname"=> $rol_rbt->surname,
                    
                ];
            }),
            
            "roles_bcba" => UserCollection::make($role_bcba),
             "roles_bcba"=>$role_bcba->map(function($rol_bcba){
                return[
                    // "location_id"=> $rol_bcba->location_id,
                    "id"=> $rol_bcba->id,
                    "avatar"=> $rol_bcba->avatar,
                    "electronic_signature"=> $rol_bcba->electronic_signature,
                    "name"=> $rol_bcba->name,
                    "surname"=> $rol_bcba->surname,
                    
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
    public function storebcba(Request $request)
    {
        $patient = null;
        $patient = Patient::where("patient_id", $request->patient_id)->first();
        $doctor = User::where("id", $request->doctor_id)->first();

        $request->request->add(["caregiver_goals"=>json_encode($request->caregiver_goals)]);
        $request->request->add(["rbt_training_goals"=>json_encode($request->rbt_training_goals)]);

        if($request->hasFile('imagen')){
            $path = Storage::putFile("notebcbas", $request->file('imagen'));
            $request->request->add(["provider_signature"=>$path]);
        }
        if($request->hasFile('imagenn')){
            $path = Storage::putFile("notebcbas", $request->file('imagenn'));
            $request->request->add(["supervisor_signature"=>$path]);
        }

        if($request->birth_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->birth_date );
            $request->request->add(["birth_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }


        if($request->session_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->session_date );
            $request->request->add(["session_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }
        if($request->next_session_is_scheduled_for){
            $date_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->next_session_is_scheduled_for );
            $request->request->add(["next_session_is_scheduled_for" => Carbon::parse($date_clean1)->format('Y-m-d h:i:s')]);
        }

        if($request->time_in){
            $time_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->time_in );
            $request->request->add(["time_in" => Carbon::parse($time_clean)->format('h:i:s')]);
        }
        if($request->time_out){
            $time_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->time_out );
            $request->request->add(["time_out" => Carbon::parse($time_clean1)->format('h:i:s')]);
        }
        if($request->time_in2){
            $time_clean3 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->time_in2 );
            $request->request->add(["time_in2" => Carbon::parse($time_clean3)->format('h:i:s')]);
        }
        if($request->time_out2){
            $time_clean4 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->time_out2 );
            $request->request->add(["time_out2" => Carbon::parse($time_clean4)->format('h:i:s')]);
        }

        $noteBcba = NoteBcba::create($request->all());
        

        return response()->json([
            "message" => 200,
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
        $noteBcba = NoteBcba::findOrFail($id);

        return response()->json([
            "noteBcba" => NoteBcbaResource::make($noteBcba),
            "caregiver_goals"=>json_decode($noteBcba-> caregiver_goals),
            "rbt_training_goals"=>json_decode($noteBcba-> rbt_training_goals),
        ]);
    }


    public function showByPatientId($patient_id)
    {
        $noteBcbas = NoteBcba::where("patient_id", $patient_id)->orderBy('id', 'desc')->get();
        $patient = Patient::where("patient_id", $patient_id)->first();
    
        return response()->json([
            "noteBcbas" => NoteBcbaCollection::make($noteBcbas),
        ]);

        
    }


    public function showNoteBcbaByPatient($patient_id)
    {
        $noteBcba = NoteBcba::where("patient_id", $patient_id)->get();
        $patient = Patient::findOrFail($patient_id);
    
        return response()->json([
            // "noteBcba" => $noteBcba,
            "noteBcba" => NoteBcbaCollection::make($noteBcba),
            "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : [],
        ]);

        
    }
    public function showReplacementsByPatient($patient_id)
    {
        $patient = Patient::where("patient_id", $patient_id)->first();
        $familiEnvolments = FamilyEnvolment::where("patient_id", $patient_id)->get();
        $monitoringEvaluatingPatientIds = MonitoringEvaluating::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
        "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : null,
            "familiEnvolments" =>FamilyEnvolmentGoalsCollection::make($familiEnvolments) ,
            "monitoringEvaluatingPatientIds" => MonitoringEvaluatingCollection::make($monitoringEvaluatingPatientIds),
            // "rbt_training_goals"=>json_decode($monitoringEvaluatingPatientIds-> rbt_training_goals),
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
        $noteBcba = NoteBcba::findOrFail($id);

        $request->request->add(["caregiver_goals"=>json_encode($request->caregiver_goals)]);
        $request->request->add(["rbt_training_goals"=>json_encode($request->rbt_training_goals)]);

        if($request->hasFile('imagen')){
            $path = Storage::putFile("notebcbas", $request->file('imagen'));
            $request->request->add(["provider_signature"=>$path]);
        }
        if($request->hasFile('imagenn')){
            $path = Storage::putFile("notebcbas", $request->file('imagenn'));
            $request->request->add(["supervisor_signature"=>$path]);
        }

        if($request->birth_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->birth_date );
            $request->request->add(["birth_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        if($request->session_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->session_date );
            $request->request->add(["session_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }


        $noteBcba->update($request->all());

        return response()->json([
            "message" => 200,
            "noteBcba"=>$noteBcba,
            "caregiver_goals"=>json_decode($noteBcba-> caregiver_goals),
            "rbt_training_goals"=>json_decode($noteBcba-> rbt_training_goals),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $noteBcba = NoteBcba::findOrFail($id);
        $noteBcba->delete();
        return response()->json([
            "message" => 200,
        ]);
    }

    public function atendidas()
    {
        
        $noteBcbas = NoteBcba::where('status', 2)->orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            "total"=>$noteBcbas->total(),
            "noteBcbas"=> NoteBcbaCollection::make($noteBcbas)
        ]);

    }

    public function updateStatus(Request $request, $id)
    {
        $noteBcba = NoteBcba::findOrfail($id);
        $noteBcba->status = $request->status;
        $noteBcba->update();
        return $noteBcba;
        
    }

    public function updateModifier(Request $request, $id)
    {
        $noteBcba = NoteBcba::findOrfail($id);
        $noteBcba->billedbcba = $request->billedbcba;
        $noteBcba->paybcba = $request->paybcba;
        $noteBcba->mdbcba = $request->mdbcba;
        $noteBcba->md2bcba = $request->md2bcba;
        $noteBcba->update();
        return $noteBcba;
        
    }
}
