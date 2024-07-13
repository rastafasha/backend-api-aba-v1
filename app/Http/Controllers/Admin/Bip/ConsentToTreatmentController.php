<?php

namespace App\Http\Controllers\Admin\Bip;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bip\ConsentToTreatment;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Bip\ConsentToTreatmentCollection;

class ConsentToTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consentToTreatments = ConsentToTreatment::orderBy("id", "desc")
                            ->paginate(10);
                    
        return response()->json([
            "consentToTreatments" => $consentToTreatments ,
            // "goals" => ReductionGoalsResource::make($goals) ,
            
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

        if($request->hasFile('imagen')){
            $path = Storage::putFile("signatures", $request->file('imagen'));
            $request->request->add(["analyst_signature"=>$path]);
        }

        if($request->analyst_signature_date){
            $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->analyst_signature_date );
            $request->request->add(["analyst_signature_date" => Carbon::parse($date_clean)->format('Y-m-d h:i:s')]);
        }

        if($request->hasFile('imagenn')){
            $path = Storage::putFile("signatures", $request->file('imagenn'));
            $request->request->add(["parent_guardian_signature"=>$path]);
        }

        if($request->parent_guardian_signature_date){
            $date_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->parent_guardian_signature_date );
            $request->request->add(["parent_guardian_signature_date" => Carbon::parse($date_clean1)->format('Y-m-d h:i:s')]);
        }

        
        $consentToTreatment = ConsentToTreatment::create($request->all());
        
        
        return response()->json([
            "message"=>200,
            "id"=>$consentToTreatment->id,
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
        $consentToTreatment = ConsentToTreatment::findOrFail($id);

        if($request->hasFile('imagen')){
            if($bip->analyst_signature){
                Storage::delete($bip->analyst_signature);
            }
            $path = Storage::putFile("signatures", $request->file('imagen'));
            $request->request->add(["analyst_signature"=>$path]);
        }
        if($request->hasFile('imagenn')){
            if($bip->parent_guardian_signature){
                Storage::delete($bip->parent_guardian_signature);
            }
            $path = Storage::putFile("signatures", $request->file('imagenn'));
            $request->request->add(["parent_guardian_signature"=>$path]);
        }

        if($request->parent_guardian_signature_date){
            $date_clean1 = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '',$request->parent_guardian_signature_date );
            $request->request->add(["parent_guardian_signature_date" => Carbon::parse($date_clean1)->format('Y-m-d h:i:s')]);
        }
        $consentToTreatment->update($request->all());
        
        return response()->json([
            "message"=>200,
            "consentToTreatment"=>$consentToTreatment,
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
        $consentToTreatment = ConsentToTreatment::findOrFail($id);

        return response()->json([
            "consentToTreatment" => $consentToTreatment,
            
        ]);
        
    }

    public function showbyProfile($id)
    {
        $patient = ConsentToTreatment::where("client_id","<>", $id)->first();
        return response()->json([
            "patient" => $patient,
        ]);

        
    }


    public function showgbyPatientId($patient_id)
    {
        $consentToTreatmentPatientIds = ConsentToTreatment::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
            "consentToTreatmentPatientIds" => ConsentToTreatmentCollection::make($consentToTreatmentPatientIds)
            
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
        $consentToTreatment = ConsentToTreatment::findOrFail($id);
        $consentToTreatment->delete();
        return response()->json([
            "message" => 200
        ]);
    }
}
