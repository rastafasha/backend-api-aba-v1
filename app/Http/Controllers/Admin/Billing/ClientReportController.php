<?php

namespace App\Http\Controllers\Admin\Billing;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use App\Models\Insurance\Insurance;
use App\Http\Controllers\Controller;
use App\Models\Billing\ClientReport;
use App\Http\Resources\Bip\BipResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Note\NoteRbtResource;
use App\Http\Resources\Note\NoteRbtCollection;
use App\Http\Resources\Billing\BillingResource;
use App\Http\Resources\Note\NoteBcbaCollection;
use App\Http\Resources\Billing\BillingCollection;
use App\Http\Resources\Insurance\InsuranceCollection;
use App\Http\Resources\Billing\ClientReport\ClientReportCollection;

class ClientReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search_doctor = $request->search_doctor;
        $search_tecnicoRbt = $request->search_tecnicoRbt;
        $search_supervisor = $request->search_supervisor;
        // $search_patient = $request->search_patient;
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $clientReports = NoteRbt::filterAdvanceClientReport(
            $search_doctor, 
            $search_tecnicoRbt, 
            $search_supervisor, 
            // $search_patient,
            $date_start,$date_end
            )
                            ->paginate(10);
        return response()->json([
            "total"=>$clientReports->total(),
            "clientReports"=> NoteRbtCollection::make($clientReports)
        ]);

        // $name_doctor = $request->search;
        // $doctor_id = $request->doctor_id;
        // $session_date = $request->session_date;
        // $patient_id = $request->patient_id;
        // $provider_name_g = $request->provider_name_g;
        // // $npi = $request->npi;

        // $clientReports = NoteRbt::filterAdvanceClientReport(
        //     $provider_name_g,
        //     $session_date, 
        //     $patient_id,
        //     $doctor_id
        //     )->orderBy("id", "desc")
        //                     ->paginate(10);
        // return response()->json([
        //     "total"=>$clientReports->total(),
        //     "clientReports"=> NoteRbtCollection::make($clientReports)
        //     // "clientReports"=> ClientReportCollection::make($clientReports)
        // ]);

        

        
    }

   

    public function config(){

        $insurances = Insurance::get();
        $users= User::orderBy("id", "desc")->get();

        return response()->json([
            // "insurances"=>$users,
            "doctors" =>UserCollection::make($users),
            "doctors"=>$users->map(function($user){
                return[
                    "id"=> $user->id,
                    "name"=>$user->name,
                    "surname"=>$user->surname,
                    "full_name"=>$user->name.' '.$user->surname,
                    "npi"=>$user->npi,
                ];
            }),
            "insurances"=>$insurances,
            "insurances" =>InsuranceCollection::make($insurances),
            "insurances"=>$insurances->map(function($insurance){
                return[
                    "id"=> $insurance->id,
                    "insurer_name"=>$insurance->insurer_name,
                    "services"=>json_decode($insurance->services),
                    "notes"=>json_decode($insurance->notes),
                ];
            }),
            
        ]);
    }



    // mostrar data por el paciente

    public function showByPatientId(Request $request)
    {

        //search
        // $search_doctor = $request->search_doctor;
        // $search_tecnicoRbt = $request->search_tecnicoRbt;
        // $search_supervisor = $request->search_supervisor;
        // // $search_patient = $request->search_patient;
        // $date_start = $request->date_start;
        // $date_end = $request->date_end;

        // $clientReports = NoteRbt::filterAdvanceClientReport(
        //     $search_doctor, 
        //     $search_tecnicoRbt, 
        //     $search_supervisor, 
        //     // $search_patient,
        //     $date_start,$date_end)
        //                     ->paginate(10);
        //search

        $name_doctor = $request->search;
        $session_date = $request->session_date;
        $patient_id = $request->patient_id;
        $id = $request->provider_name_g;
        $provider_name_g = $request->provider_name_g;
        $supervisor_name = $request->supervisor_name;

        $patient = Patient::where("patient_id", $patient_id)->first();

        $noteBcba = NoteBcba::where("patient_id", $patient_id)
        ->orderBy('session_date','desc')->get();

        $noteRbt = NoteRbt::where("patient_id", $patient_id)
        ->orderBy('session_date','desc')
            ->get();
        $tecnicoRbts = NoteRbt::where("patient_id", $patient_id) 
            ->with('doctor', 'desc')
            ->where('provider_name_g', $id)
            ->orderby('session_date', 'desc')
            ->get();

        $doctors = Patient::join('users', 'patients.id', '=', 'users.id')
            ->select(
                
                'patients.id as id',
                'users.name',
                )
            ->get();

        
        $doctor = NoteRbt::where("provider_name_g", $provider_name_g)->get();
        $tecnicoRbts = NoteRbt::where("provider_name_g" , $provider_name_g)->get();
        $supervisor = NoteRbt::where("supervisor_name", $supervisor_name)->get();

        // $doctors = NoteRbt::join('users', 'noterbt.provider_name_g', '=', 'users.id')
        // ->select(
        //     'noterbt.provider_name_g as id',
        //     'users.name'
        //     )
        // ->get();
        
        // if ($name_doctor != ""){
        //     $doctor = $this->filterDoctorName($doctor,$name_doctor);
        // }
        // if ($session_date != ""){
        //     $doctor = $this->filterDate($doctor,$session_date);
        // }

        
        if($request->{'xe'}){
            $request->request->add($xe);
        }

       
        $notes = [];

        foreach ($noteRbt as $note) {

            /*Session 1*/
            $timeIn = Carbon::parse($note->time_in);
            $timeOut = Carbon::parse($note->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($note->time_in2);
            $timeOut2 = Carbon::parse($note->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15); 
            
            /*Costo por unidad*/
            $costoUnidad = 12.51;

            /*Pagar*/
            $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo

            $notes[] =[              
                'id' => $note->id,
                // 'Doctor id' => $note->doctor_id,
                'Paciente' => $note->patient_id,
                'bip_id' => $note->bip_id,
                'supervisor' => $note->supervisor_name,
                'supervisor'=>$note-> supervisor,
                'supervisor'=>[
                    'name'=> $note->supervisor->name,
                    'surname'=> $note->supervisor->surname,
                    'npi'=> $note->supervisor->npi,
                ],
                'tecnicoRbts' => $note->provider_name_g,
                'tecnicoRbt'=>$note-> tecnicoRbt,
                'tecnicoRbt'=>[
                    'name'=> $note->tecnicoRbt->name,
                    'surname'=> $note->tecnicoRbt->surname,
                    'npi'=> $note->tecnicoRbt->npi,
                ],
                
                
                'pos' => $note->pos,
                'session_date' => $note->session_date,
                'meet_with_client_at' => $note->meet_with_client_at,
                'time_in' => $note->time_in,
                'time_out' => $note->time_out,
                'time_in2' => $note->time_in2,
                'time_out2' => $note->time_out2,
                "total_hours" => date("H:i",strtotime($note->time_out) - strtotime($note->time_in) + strtotime($note->time_out2) - strtotime($note->time_in2)  ),
                
                'cpt_code' => $note->cpt_code,
                'md' => $note->md,
                'md2' => $note->md2,
                
                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,
                'billed' => $note->billed,
                'pay' => $note->pay,
                'created_at' => $note->created_at,

                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,
                
            ];

            
        }

        $noteBcbas = [];

        foreach ($noteBcba as $notebcba) {

            /*Session 1*/
            $timeIn = Carbon::parse($notebcba->time_in);
            $timeOut = Carbon::parse($notebcba->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($notebcba->time_in2);
            $timeOut2 = Carbon::parse($notebcba->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15); 
            
            /*Costo por unidad*/
            $costoUnidad = 12.51;

            /*Pagar*/
            $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo

            
            $notesBcbas[] =[              
                'id' => $notebcba->id,
                // 'Doctor id' => $note->doctor_id,
                'Paciente' => $notebcba->patient_id,
                'bip_id' => $notebcba->bip_id,
                "cpt_code"=> $notebcba->cpt_code,
                    "provider_name"=> $notebcba->provider_name,
                    "session_date"=> $notebcba->session_date,
                    'tecnico'=>$notebcba-> tecnico,
                    // 'time_in' => $noteBcba->time_in,
                    // 'time_out' => $noteBcba->time_out,
                    // 'time_in2' => $noteBcba->time_in2,
                    // 'time_out2' => $noteBcba->time_out2,
                    "total_hours" => date("H:i",strtotime($notebcba->time_out) - strtotime($notebcba->time_in) + strtotime($notebcba->time_out2) - strtotime($notebcba->time_in2)  ),
                    'tecnico'=>[
                        'name'=> $notebcba->tecnico->name,
                        'surname'=> $notebcba->tecnico->surname,
                        'npi'=> $notebcba->tecnico->npi,
                    ],
                    "supervisor_name"=> $notebcba->supervisor_name,
                    'supervisor'=>$notebcba-> supervisor,
                    'supervisor'=>[
                        'name'=> $notebcba->supervisor->name,
                        'surname'=> $notebcba->supervisor->surname,
                        'npi'=> $notebcba->supervisor->npi,
                    ],
                    "aba_supervisor"=> $notebcba->aba_supervisor,
                    'abasupervisor'=>$notebcba-> abasupervisor,
                    'abasupervisor'=>[
                        'name'=> $notebcba->abasupervisor->name,
                        'surname'=> $notebcba->abasupervisor->surname,
                        'npi'=> $notebcba->abasupervisor->npi,
                    ],
                'cpt_code' => $notebcba->cpt_code,
                'mdbcba' => $notebcba->mdbcba,
                'md2bcba' => $notebcba->md2bcba,
                'billedbcba' => $notebcba->billedbcba,
                'paybcba' => $notebcba->paybcba,
                'meet_with_client_at' => $notebcba->meet_with_client_at,
                
                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,

                'created_at' => $notebcba->created_at,
    
                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,
                
            ];

            
        }
        
        
        return response()->json([
            'noteBcbas'=> $notesBcbas,
            // "noteBcba"=>$notesBcbas->map(function($noteBcba){
            //     return[
            //         "cpt_code"=> $noteBcba->cpt_code,
            //         "provider_name"=> $noteBcba->provider_name,
            //         "session_date"=> $noteBcba->session_date,
            //         'tecnico'=>$noteBcba-> tecnico,
            //         // 'time_in' => $noteBcba->time_in,
            //         // 'time_out' => $noteBcba->time_out,
            //         // 'time_in2' => $noteBcba->time_in2,
            //         // 'time_out2' => $noteBcba->time_out2,
            //         "total_hours" => date("H:i",strtotime($noteBcba->time_out) - strtotime($noteBcba->time_in) + strtotime($noteBcba->time_out2) - strtotime($noteBcba->time_in2)  ),
            //         'tecnico'=>[
            //             'name'=> $noteBcba->tecnico->name,
            //             'surname'=> $noteBcba->tecnico->surname,
            //             'npi'=> $noteBcba->tecnico->npi,
            //         ],
            //         "supervisor_name"=> $noteBcba->supervisor_name,
            //         'supervisor'=>$noteBcba-> supervisor,
            //         'supervisor'=>[
            //             'name'=> $noteBcba->supervisor->name,
            //             'surname'=> $noteBcba->supervisor->surname,
            //             'npi'=> $noteBcba->supervisor->npi,
            //         ],
            //         "aba_supervisor"=> $noteBcba->aba_supervisor,
            //         'abasupervisor'=>$noteBcba-> abasupervisor,
            //         'abasupervisor'=>[
            //             'name'=> $noteBcba->abasupervisor->name,
            //             'surname'=> $noteBcba->abasupervisor->surname,
            //             'npi'=> $noteBcba->abasupervisor->npi,
            //         ],
            //     ];
            // }),
            // "doctors" =>$doctors,
           
            "noteRbts" =>$notes,
            // "noteRbts" => NoteRbtCollection::make($notes),
            
            "patient" => $patient,
                "patient"=>$patient->id ? [
                    "patient_id"=> $patient->patient_id,
                    "full_name"=> $patient->first_name.' '.$patient->last_name,
                    "patient_id"=>$patient->patient_id,
                    "first_name"=>$patient->first_name,
                    "last_name"=>$patient->last_name,
                    "diagnosis_code"=>$patient->diagnosis_code,
                    // "pos_covered"=>$patient->pos_covered,
                    "pos_covered"=>$patient->pos_covered ? json_decode($patient->pos_covered) : null,
                    "insurer_id"=>$patient->insurer_id,
                    "rbt_home_id"=>$patient->rbt_home_id,
                    "rbt2_school_id"=>$patient->rbt2_school_id,
                    "bcba_home_id"=>$patient->bcba_home_id,
                    "bcba2_school_id"=>$patient->bcba2_school_id,
                    // "bcba2_school"=>$patient->bcba2_school_id ? [
                        //     "id"=> $bcba2_school->bcba2_school_id,
                        //     "name"=>$bcba2_school->name,
                        //     "surname"=>$bcba2_school->surname,
                        // ]:NULL,
                        ]:NULL,
                        
                        
                        "pos_covered"=>$patient->pos_covered ? json_decode($patient->pos_covered) : null,
            

            "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : null,
        ]);
    }



    // public function showByPatientId(Request $request)
    // {
    //     $name_doctor = $request->search;
    //     $session_date = $request->session_date;
    //     $patient_id = $request->patient_id;
    //     $id = $request->provider_name_g;
    //     $provider_name_g = $request->provider_name_g;

    //     $patient = Patient::where("patient_id", $patient_id)->first();
    //     $tecnicoRbts = User::orderBy("id","desc")->get();
    //     // $tecnicorbt = NoteRbt::where("provider_name_g", $provider_name_g)->get();
    //     // $supervisorbcba = NoteRbt::where("supervisor_name", $supervisor_name)->get();
        
    //     if ($name_doctor != ""){
    //         $doctor = $this->filterDoctorName($doctor,$name_doctor);
    //     }
    //     if ($session_date != ""){
    //         $doctor = $this->filterDate($doctor,$session_date);
    //     }

        
        
    //     $noteRbt = NoteRbt::where("patient_id", $patient_id) 
    //     ->orderby('session_date', 'desc')
    //     ->get();
        
    //     $noteBcba = NoteBcba::where("patient_id", $patient_id) 
    //     ->get();
        

    //     $clientReports = ClientReport::filterAdvance($name_doctor, $session_date)->where("patient_id", $patient_id)
    //     ->orderby('session_date', 'asc')
    //     ->get();

        

    //     return response()->json([
    //         "full_name"=> $patient->first_name.' '.$patient->last_name,
    //         "patient_id"=> $patient->patient_id,
    //         "patient" => $patient,
    //         "patient"=>$patient->id ? [
    //             "id"=> $patient->id,
    //             "patient_id"=>$patient->patient_id,
    //             "first_name"=>$patient->first_name,
    //             "last_name"=>$patient->last_name,
    //             "diagnosis_code"=>$patient->diagnosis_code,
    //             "pos_covered"=>$patient->pos_covered,
    //             "insurer_id"=>$patient->insurer_id,
    //         ]:NULL,

             
            
            
    //         "noteRbt" => NoteRbtCollection::make($noteRbt),
    //         "noteRbt"=>$noteRbt->map(function($noteRbt){
    //             return[
    //                 "id"=> $noteRbt->id,
    //                 "pos" => $noteRbt->pos,
    //                 "billed" => $noteRbt->billed,
    //                 "pay" => $noteRbt->pay,
    //                 "tecnicoRbt" => $noteRbt->provider_name_g,
    //                 "provider_name_g" => $tecnicoRbt->map(function($tecnicorbt){
    //                     return [
    //                         "id" => $noteRbt->provider_name_g,
    //                         // "full_name" => $tecnicorbt->name.' '.$tecnicoRbt->surname,
    //                     ];
    //                 }),
    //                 "supervisor_name" =>$noteRbt->supervisor_name,

    //                 // "supervisor_name"=>$noteRbt->supervisor_name ? [
    //                 //     "id"=>$noteRbt->supervisor_name,
    //                 //     "full_name"=>$noteRbt->supervisor_name->name.' '.$noteRbt->supervisor_name->surname,
    //                 // ]:NULL,

                   

    //                 "time_in" => ($noteRbt->time_in),
    //                 "time_out" => ($noteRbt->time_out),
    //                 "time_in2" => ($noteRbt->time_in2),
    //                 "time_out2" => ($noteRbt->time_out2),

    //                 "session_1" => date("H:i", strtotime($noteRbt->time_out) - strtotime($noteRbt->time_in) ),
    //                 "session_2" => date("H:i", strtotime($noteRbt->time_out2) - strtotime($noteRbt->time_in2) ),
    //                 // "session_f2" => ($noteRbt->time_out2 - $noteRbt->time_in2/100)*1.66666666666667,

    //                 "total_hours" => date("H:i", strtotime($noteRbt->time_out2) - strtotime($noteRbt->time_in2) + strtotime($noteRbt->time_out) - strtotime($noteRbt->time_in) ),
    //                 //1
    //                 "hour_to_minute" => strtotime(strtotime(date("H:i", strtotime($noteRbt->time_out2) - strtotime($noteRbt->time_in2) + strtotime($noteRbt->time_out) - strtotime($noteRbt->time_in)) ) *60)*24,
    //                 //
    //                 "total_hoursFactor" => strtotime(date("H:i", strtotime($noteRbt->time_out2) - strtotime($noteRbt->time_in2) + strtotime($noteRbt->time_out) - strtotime($noteRbt->time_in)) ) *1.66666666666667,
    //                 "total_units" => (strtotime(strtotime(date("H:i", strtotime($noteRbt->time_out2) - strtotime($noteRbt->time_in2) + strtotime($noteRbt->time_out) - strtotime($noteRbt->time_in)) ) *60)*24)*1.66666666666667 /100 *4,
                    
    //                 "session_date" => $noteRbt->session_date ? Carbon::parse($noteRbt->session_date)->format("Y-m-d") : NULL,
    //             ];
    //         }),
    //         "noteBcba" => NoteBcbaCollection::make($noteBcba),
    //         "noteBcba"=>$noteBcba->map(function($noteBcba){
    //             return[
    //                 "cpt_code"=> $noteBcba->cpt_code,
    //             ];
    //         }),
    //         "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : null,
            
            
    //     ]);

        
    // }


    public function store(Request $request)
    {
        $patient = null;
        // $noteRbt = NoteRbt::where("id", $request->noterbt_id)->first();
        // $billed = NoteRbt::where('billed', 0)->update(['billed' => $request->billed]);
        // $pay = NoteRbt::where('pay', 0)->update(['pay' => $request->pay]);
        // $appointment_attention = $request->session_date;

        $patient = Patient::where("patient_id", $request->patient_id)->first();
        $patient = Patient::where("patient_id", $request->patient_id)->first();
        $doctor = User::where("id", $request->doctor_id)->first();
        

        $clientReport = ClientReport::create($request->all());

        
        
        return response()->json([
            "message"=>200,
            "clientReport"=>$clientReport,
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
        $clientReport = ClientReport::findOrFail($id);
        // $patient = Patient::where("patient_id", $patient_id)->first();

        return response()->json([
            "clientReport" => BillingResource::make($clientReport),
            
        ]);
    }
    //traer el perfil con los datos del insurer aplicados en el registro
    public function showProfile($patient_id)
    {
        $patient = Patient::where("patient_id", $patient_id)->first();
        $noteRbt = NoteRbt::where("patient_id", $patient_id)->get();


        return response()->json([
            // "patient" => $patient,
            // "noteRbt" => $noteRbt,
            "full_name"=> $patient->first_name.' '.$patient->last_name,
            "patient_id"=> $patient->patient_id,
            "insurer_id"=> $patient->insurer_id,
            "noteRbt" => NoteRbtCollection::make($noteRbt),
            "noteRbt"=>$noteRbt->map(function($noteRbt){
                return[
                    "id"=> $noteRbt->id,
                    "pos" => $noteRbt->pos,
                    "time_in" => $noteRbt->time_in,
                    "time_out" => $noteRbt->time_out,
                    "time_in2" => $noteRbt->time_in2,
                    "time_out2" => $noteRbt->time_out2,
                ];
            }),

            "pa_assessments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : null,
            
            // "bip" => BipResource::make($bip),
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
        //
    }

    public function updateTotals(Request $request, $id)
    {
        $clientReport = ClientReport::findOrfail($id);
        $clientReport->billing_total = $request->billing_total;
        $clientReport->week_total_hours = $request->week_total_hours;
        $clientReport->week_total_units = $request->week_total_units;
        $clientReport->cpt_code = $request->cpt_code;
        $clientReport->insurer_id = $request->insurer_id;
        $clientReport->insurer_rate = $request->insurer_rate;
        $clientReport->update();
        return $clientReport;
        
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



    public function contadorShow($id)
    {
        $contador = Contador::find($id);

        $timeIn = Carbon::parse($contador->time_in);
        $timeOut = Carbon::parse($contador->time_out);

        $diferencia = $timeOut->diff($timeIn);


        $timeIn2 = Carbon::parse($contador->time_in2);
        $timeOut2 = Carbon::parse($contador->time_out2);

        $diferencia2 = $timeOut2->diff($timeIn2);
        
        $horas = $diferencia->h;
        $minutos = $diferencia->i;
        
        $horas2 = $diferencia2->h;
        $minutos2 = $diferencia2->i;


        /**sfdsd */
        $minutosTotales1 = $diferencia->h * 60 + $diferencia->i;

        $minutosTotales2 = $diferencia2->h * 60 + $diferencia2->i;
    
        $unidades1 = round($minutosTotales1 / 15);
        $unidades2 = round($minutosTotales2 / 15);


        $duracionTotalMinutos = $diferencia->h * 60 + $diferencia->i + $diferencia2->h * 60 + $diferencia2->i;

        $horas = floor($duracionTotalMinutos / 60);
        $minutos = $duracionTotalMinutos % 60;


        $diferenciaTotal = "$horas horas, $minutos minutos";

        $totalUnidades = $unidades1 + $unidades2;

        $costoUnidad = 12.51;

        $pagar = $totalUnidades * $costoUnidad;

        return [
            'Session 1' => "Diferencia: $horas horas, $minutos minutos",
            'Unidad sesion 1' => "Unidades: $unidades1",
            'Session 2' => "Diferencia: $horas2 horas, $minutos2 minutos",
            'Unidad sesion 2' => "Unidades: $unidades2",
            'Total de minutos' => "Total de minutos $diferenciaTotal",
            'Total de Unidades' => "Total de unidades $totalUnidades",
            'Pagar' => $pagar
        ];

    }


}
