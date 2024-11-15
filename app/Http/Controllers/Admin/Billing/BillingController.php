<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Models\User;
use App\Models\Billing\Billing;
use Illuminate\Http\Request;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Models\Insurance\Insurance;
use App\Http\Controllers\Controller;
use App\Http\Resources\Billing\BillingResource;
use App\Http\Resources\Billing\BillingCollection;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = Billing::orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            // "total"=>$patients->total(),
            // "billings"=> $billings
            "billings" => BillingCollection::make($billings)
        ]);
    }

    public function config()
    {

        $insurances = Insurance::get();
        $users = User::orderBy("id", "desc")->get();

        return response()->json([
            "doctors" => $users,
            "insurances" => $insurances,
            // "doctors"=>$users->map(function($user){
            //     return[
            //         "id"=> $user->id,
            //         "full_name"=> $user->name.' '.$user->surname,
            //     ];
            // }),
            // "patients"=>$patients->map(function($patient){
            //     return[
            //         "id"=> $user->id,
            //         "full_name"=> $patient->name.' '.$patient->surname,
            //     ];
            // })
        ]);
    }
    // mostrar data por el paciente
    public function showByPatientId($patient_id)
    {
        $billings = Billing::where("patient_id", $patient_id)
        ->orderby('date', 'desc')
        // ->groupby('date')
        // ->selectRaw('sum(total_hours) as total, date')
        ->get();
        // $patient = Patient::where("patient_id", $patient_id)->first();

        return response()->json([
            "billings" => $billings,
            // "billings" => BillingCollection::make($billings),
        ]);
    }
    //mostrar al paciente
    public function showPatientId($patient_id)
    {
        $patient_is_valid = Billing::where("patient_id", $request->patient_id)->first();
        $patient = Patient::where("patient_id", $patient_id)->orderby('date', 'desc')
        // ->groupby('date')
        // ->selectRaw('sum(total_hours) as total, date')
        ->get();
        // $patient = Patient::where("patient_id", $patient_id)->first();

        return response()->json([
            // "note_rbts" => NoteRbtResource::make($note_rbts),
            "billings" => BillingCollection::make($billings),
            // "note_rbts" => $note_rbts,
            // "patient" => $patient,
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
        $billing = Billing::findOrFail($id);
        // $patient = Patient::where("patient_id", $patient_id)->first();

        return response()->json([
            "billing" => BillingResource::make($billing),
            // "interventions"=>json_decode($noteRbt-> interventions),
            // "maladaptives"=>json_decode($noteRbt-> maladaptives),
            // "replacements"=>json_decode($noteRbt-> replacements),
            // "patient"=>$billing->patient,
            // "patient"=>$patient->map(function($patient){
            //     return[
            //         "id"=> $patient->id,
            //         "full_name"=> $patient->first_name.' '.$patient->last_name,
            //         "insurance_id"=> $patient->insurance_id,
            //     ];
            // }),
            // "supervisor_name"=>$noteRbt->supervisor_name,
            // "supervisor_name"=>$doctor->map(function($supervisor_name){
            //     return[
            //         "id"=> $supervisor_name->id,
            //         "full_name"=> $supervisor_name->name.' '.$supervisor_name->surname,
            //     ];
            // }),
            // "provider_name_g"=>$noteRbt->provider_name_g,
            // "provider_name_g"=>$doctor->map(function($provider_name_g){
            //     return[
            //         "id"=> $provider_name_g->id,
            //         "full_name"=> $provider_name_g->name.' '.$provider_name_g->surname,
            //     ];
            // }),

        ]);
    }
    //traer el perfil con los datos del insurer aplicados en el registro
    public function showProfile($patient_id)
    {
        $patient = Patient::where("patient_id", $patient_id)->first();
        return response()->json([
            "patient" => $patient,
            "patient" => $patient->id ? [
                "id" => $patient->id,
                "patient_id" => $patient->patient_id,
                "first_name" => $patient->first_name,
                "last_name" => $patient->last_name,
                "diagnosis_code" => $patient->diagnosis_code,
                "pos_covered" => $patient->pos_covered,
                "insurer_id" => $patient->insurer_id,
            ] : null,
            "pa_assessments" => $patient->pa_assessments ? json_decode($patient->pa_assessments) : null,

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
        $billing = Billing::findOrfail($id);
        $billing->billing_total = $request->billing_total;
        $billing->week_total_hours = $request->week_total_hours;
        $billing->week_total_units = $request->week_total_units;
        $billing->cpt_code = $request->cpt_code;
        $billing->insurer_id = $request->insurer_id;
        $billing->insurer_rate = $request->insurer_rate;
        $billing->update();
        return $billing;
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
