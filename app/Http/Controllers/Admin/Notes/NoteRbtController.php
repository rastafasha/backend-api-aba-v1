<?php

namespace App\Http\Controllers\Admin\Notes;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Billing\Billing;
use App\Models\Bip\Bip;
use Illuminate\Http\Request;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Models\Bip\ReductionGoal;
use App\Models\Notes\Maladaptive;
use App\Models\Notes\Replacement;
use App\Models\Bip\SustitutionGoal;
use App\Models\Insurance\Insurance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Note\NoteRbtResource;
use App\Http\Resources\Note\NoteRbtCollection;

class NoteRbtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $note_rbts = NoteRbt::orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            // "total"=>$patients->total(),
            "note_rbts"=> NoteRbtCollection::make($note_rbts)
        ]);
    }

    public function showByPatientId($patient_id)
    {
        $note_rbts = NoteRbt::where("patient_id", $patient_id)->orderby('created_at', 'DESC')->get();
        $patient = Patient::where("patient_id", $patient_id)->first();
    
        return response()->json([
            // "note_rbts" => NoteRbtResource::make($note_rbts),
            "note_rbts" => NoteRbtCollection::make($note_rbts),
            // "note_rbts" => $note_rbts,
            // "patient" => $patient,
        ]);

        
    }

    public function showByClienttId($id)
    {
        $note_rbts = NoteRbt::where("id", $id)->get();
        $patient = Patient::where("id", $id)->first();
    
        return response()->json([
            // "note_rbts" => NoteRbtResource::make($note_rbts),
            "note_rbts" => NoteRbtCollection::make($note_rbts),
            // "note_rbts" => $note_rbts,
            // "patient" => $patient,
        ]);

        
    }

    public function config()
    {
        $hours =[
            [
                "id"=>"800",
                "name"=>"8:00 AM"
            ],
            [
                "id"=>"815",
                "name"=>"8:15 AM"
            ],
            [
                "id"=>"830",
                "name"=>"8:30 AM"
            ],
            [
                "id"=>"845",
                "name"=>"8:45 AM"
            ],
            [
                "id"=>"900",
                "name"=>"09:00 AM"
            ],
            [
                "id"=>"900",
                "name"=>"09:00 AM"
            ],
            [
                "id"=>"915",
                "name"=>"09:15 AM"
            ],
            [
                "id"=>"930",
                "name"=>"09:30 AM"
            ],
            [
                "id"=>"945",
                "name"=>"09:45 AM"
            ],
            [
                "id"=>"1000",
                "name"=>"10:00 AM"
            ],
            [
                "id"=>"1015",
                "name"=>"10:15 AM"
            ],
            [
                "id"=>"1030",
                "name"=>"10:30 AM"
            ],
            [
                "id"=>"1045",
                "name"=>"10:45 AM"
            ],
            [
                "id"=>"1100",
                "name"=>"11:00 AM"
            ],
            [
                "id"=>"1115",
                "name"=>"11:15 AM"
            ],
            [
                "id"=>"1130",
                "name"=>"11:30 AM"
            ],
            [
                "id"=>"1145",
                "name"=>"11:45 AM"
            ],
            [
                "id"=>"1200",
                "name"=>"12:00 PM"
            ],
            [
                "id"=>"1215",
                "name"=>"12:15 PM"
            ],
            [
                "id"=>"1230",
                "name"=>"12:30 PM"
            ],
            [
                "id"=>"1245",
                "name"=>"12:45 PM"
            ],
            [
                "id"=>"1300",
                "name"=>"13:00 PM"
            ],
            [
                "id"=>"1300",
                "name"=>"13:00 PM"
            ],
            [
                "id"=>"1315",
                "name"=>"13:15 PM"
            ],
            [
                "id"=>"1330",
                "name"=>"13:30 PM"
            ],
            [
                "id"=>"1345",
                "name"=>"13:45 PM"
            ],
            [
                "id"=>"1400",
                "name"=>"14:00 PM"
            ],
            [
                "id"=>"1415",
                "name"=>"14:15 PM"
            ],
            [
                "id"=>"1430",
                "name"=>"14:30 PM"
            ],
            [
                "id"=>"1445",
                "name"=>"14:45 PM"
            ],
            [
                "id"=>"1500",
                "name"=>"15:00 PM"
            ],
            [
                "id"=>"1515",
                "name"=>"15:15 PM"
            ],
            [
                "id"=>"1530",
                "name"=>"15:30 PM"
            ],
            [
                "id"=>"1545",
                "name"=>"15:45 PM"
            ],
            [
                "id"=>"1600",
                "name"=>"16:00 PM"
            ],
            [
                "id"=>"1615",
                "name"=>"16:15 PM"
            ],
            [
                "id"=>"1630",
                "name"=>"16:30 PM"
            ],
            [
                "id"=>"1645",
                "name"=>"16:45 PM"
            ],
            [
                "id"=>"1700",
                "name"=>"17:00 PM" // 5:00
            ],
            [
                "id"=>"1715",
                "name"=>"17:15 PM"
            ],
            [
                "id"=>"1730",
                "name"=>"17:30 PM"
            ],
            [
                "id"=>"1745",
                "name"=>"17:45 PM"
            ],
            [
                "id"=>"1800",
                "name"=>"18:00 PM"
            ],
            [
                "id"=>"1815",
                "name"=>"18:15 PM"
            ],
            [
                "id"=>"1830",
                "name"=>"18:30 PM"
            ],
            [
                "id"=>"1845",
                "name"=>"18:45 PM"
            ],
            [
                "id"=>"1900",
                "name"=>"19:00 PM"
            ],
            [
                "id"=>"1915",
                "name"=>"19:15 PM"
            ],
            [
                "id"=>"1930",
                "name"=>"19:30 PM"
            ],
            [
                "id"=>"1945",
                "name"=>"19:45 PM"
            ],
            [
                "id"=>"2000",
                "name"=>"20:00 PM"
            ],
            [
                "id"=>"2015",
                "name"=>"20:15 PM"
            ],
            [
                "id"=>"2030",
                "name"=>"20:30 PM"
            ],
            [
                "id"=>"2045",
                "name"=>"20:45 PM"
            ],
            [
                "id"=>"2100",
                "name"=>"21:00 PM"
            ],
            
        ];
        $specialists = User::where("status",'active')->get();
        
        // $replacements = Replacement::get(["patient_id"]);

        $role_rbt= User::orderBy("id", "desc")
        ->whereHas("roles", function($q){
            $q->where("name","like","%RBT%");
        })->get();
        $role_bcba= User::orderBy("id", "desc")
        ->whereHas("roles", function($q){
            $q->where("name","like","%BCBA%");
        })->get();

        return response()->json([
            "specialists" => $specialists,
            "hours" => $hours,
            "roles_rbt" => $role_rbt,
            "roles_bcba" => $role_bcba,
            // "roles_bcba"=>$role_bcba->map(function($role_bcba){
            //     return[
            //         "id"=> $role_bcba->id,
            //         "full_name"=> $role_bcba->name.' '.$role_bcba->surname,
            //     ];
            // }),
            // "roles_rbt"=>$role_rbt->map(function($role_rbt){
            //     return[
            //         "id"=> $role_rbt->id,
            //         "full_name"=> $role_rbt->name.' '.$role_rbt->surname,
            //     ];
            // })
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
        $imagen = null;
        $imagenn = null;
        $patient = Patient::where("patient_id", $request->patient_id)->first();
        $doctor = User::where("id", $request->doctor_id)->first();
        $insurance = Insurance::get();

        $request->request->add(["interventions"=>json_encode($request->interventions)]);
        $request->request->add(["maladaptives"=>json_encode($request->maladaptives)]);
        $request->request->add(["replacements"=>json_encode($request->replacements)]);

        
        if($request->imagen){
            $request->request->add(["provider_signature"=>$imagen]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("noterbts", $request->file('imagen'));
            $request->request->add(["provider_signature"=>$path]);
        }

        if($request->imagenn){
            $request->request->add(["supervisor_signature"=>$imagenn]);
        }
        if($request->hasFile('imagenn')){
            $path = Storage::putFile("noterbts", $request->file('imagenn'));
            $request->request->add(["supervisor_signature"=>$path]);
        }

        if($request->session_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->session_date );
            $request->request->add(["session_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        if($request->next_session_is_scheduled_for){
            $date_clean2 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->next_session_is_scheduled_for );
            $request->request->add(["next_session_is_scheduled_for" => Carbon::parse($date_clean2)->format('Y-m-d h:i:s')]);
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

       
        
        
        $noteRbt = NoteRbt::create($request->all());

        // $maladaptives = Maladaptive::create([
        //     "patient_id" => $request->patient_id,
        //     "bip_id" => $noteRbt->bip_id,
        //     "maladaptive_behavior" => json_decode(json_encode(collect($noteRbt->maladaptives)->map(function ($maladaptive) {
        //         return $maladaptive->maladaptive_behavior;
        //     }))),
        //     "number_of_occurrences" => json_decode(json_encode(collect($noteRbt->maladaptives)->map(function ($maladaptive) {
        //         return $maladaptive->number_of_occurrences;
        //     })))
        // ]);

        $billing = Billing::create([
            "sponsor_id" => $request->doctor_id,
            "patient_id" => $request->patient_id,
            "date" => $request->session_date,
            "total_hours" => date("H:i", strtotime($request->time_out2) - strtotime($request->time_in2) + strtotime($request->time_out) - strtotime($request->time_in) ),
            
            // "total_hours" => ($request->time_out - $request->time_in + $request->time_out2 - $request->time_out2)/100,
            // "total_units" => ($request->time_out - $request->time_in + $request->time_out2 - $request->time_in2)/100*4,
            // "total_units" => date("H:i", strtotime($request->time_out)-strtotime($request->time_in) + strtotime($request->time_out2)-strtotime($request->time_out2) )*4,

        ]);
        
            //envia un correo al doctor
        // Mail::to($appointment->patient->email)->send(new RegisterAppointment($appointment));
        // Mail::to($doctor->email)->send(new NewAppointmentRegisterMail($appointment));

        return response()->json([
            "message" => 200,
            // "noteRbt" => $noteRbt,
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
        $noteRbt = NoteRbt::findOrFail($id);
        $doctor = User::where("status",'active')->get();

        return response()->json([
            "noteRbt" => NoteRbtResource::make($noteRbt),
            
            // "id"=>$noteRbt->id,
            // "bip_id"=>$noteRbt->bip_id,
            // "patient_id"=>$noteRbt->patient_id,
            // "provider_credential"=>$noteRbt->provider_credential,
            // "as_evidenced_by"=>$noteRbt->as_evidenced_by,
            // "client_appeared"=>$noteRbt->client_appeared,
            // "client_response_to_treatment_this_session"=>$noteRbt->client_response_to_treatment_this_session,
            // "pos"=>$noteRbt->pos,

            "interventions"=>json_decode($noteRbt-> interventions),
            "maladaptives"=>json_decode($noteRbt-> maladaptives),
            "replacements"=>json_decode($noteRbt-> replacements),
            "provider_name"=>$noteRbt->provider_name,
            "provider_name"=>$doctor->map(function($provider_name){
                return[
                    "id"=> $provider_name->id,
                    "full_name"=> $provider_name->name.' '.$provider_name->surname,
                ];
            }),
            "supervisor_name"=>$noteRbt->supervisor_name,
            "supervisor_name"=>$doctor->map(function($supervisor_name){
                return[
                    "id"=> $supervisor_name->id,
                    "full_name"=> $supervisor_name->name.' '.$supervisor_name->surname,
                ];
            }),
            "provider_name_g"=>$noteRbt->provider_name_g,
            "provider_name_g"=>$doctor->map(function($provider_name_g){
                return[
                    "id"=> $provider_name_g->id,
                    "full_name"=> $provider_name_g->name.' '.$provider_name_g->surname,
                ];
            }),
            
        ]);
    }
    
    public function showNoteRbtByPatient($patient_id)
    {
        $noteRbt = NoteRbt::where("patient_id", $patient_id)->get();
    
        return response()->json([
            // "noteRbt" => $noteRbt,
            "noteRbt" => NoteRbtCollection::make($noteRbt),
            
        ]);

        
    }
    public function showReplacementsByPatient($patient_id)
    {
        $replacementGoals = SustitutionGoal::where("patient_id", $patient_id)->get();
    
        return response()->json([
            "replacementGoals" => $replacementGoals,
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
        $imagen = null;
        $imagenn = null;
        $noteRbt = NoteRbt::findOrFail($id);

        $request->request->add(["interventions"=>json_encode($request->interventions)]);
        $request->request->add(["maladaptives"=>json_encode($request->maladaptives)]);
        $request->request->add(["replacements"=>json_encode($request->replacements)]);

        if($request->imagen){
            $request->request->add(["provider_signature"=>$imagen]);
            print_r('imagen');
        }

        if($request->hasFile('imagen')){
            print_r('imagen');
            $path = Storage::putFile("noterbts", $request->file('imagen'));
            $request->request->add(["provider_signature"=>$path]);
        }


        if($request->imagenn){
            $request->request->add(["supervisor_signature"=>$imagenn]);
        }
        if($request->hasFile('imagenn')){
            $path = Storage::putFile("noterbts", $request->file('imagenn'));
            $request->request->add(["supervisor_signature"=>$path]);
        }

        if($request->session_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->session_date );
            $request->request->add(["session_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }
        if($request->next_session_is_scheduled_for){
            $date_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->next_session_is_scheduled_for );
            $request->request->add(["next_session_is_scheduled_for" => Carbon::parse($date_clean1)->format('Y-m-d h:i:s')]);
        }



        $noteRbt->update($request->all());

        return response()->json([
            "message" => 200,
            "noteRbt"=>$noteRbt,
            "interventions"=>json_decode($noteRbt-> interventions),
            "maladaptives"=>json_decode($noteRbt-> maladaptives),
            "replacements"=>json_decode($noteRbt-> replacements),
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
        $noteRbt = NoteRbt::findOrFail($id);
        $noteRbt->delete();
        return response()->json([
            "message" => 200,
        ]);
    }

    public function atendidas()
    {
        
        $noteRbts = NoteRbt::where('status', 2)->orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            "total"=>$noteRbts->total(),
            "noteRbts"=> NoteRbtCollection::make($noteRbts)
        ]);

    }

    public function updateStatus(Request $request, $id)
    {
        $noteRbt = NoteRbt::findOrfail($id);
        $noteRbt->status = $request->status;
        $noteRbt->update();
        return $noteRbt;
        
    }
    public function updateModifier(Request $request, $id)
    {
        $noteRbt = NoteRbt::findOrfail($id);
        $noteRbt->billed = $request->billed;
        $noteRbt->pay = $request->pay;
        $noteRbt->md = $request->md;
        $noteRbt->md2 = $request->md2;
        $noteRbt->update();
        return $noteRbt;
        
    }
}
