<?php

namespace App\Http\Controllers\Admin\Bip;

use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Models\Bip\FamilyEnvolment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bip\FamilyEnvolmentGoalsResource;
use App\Http\Resources\Bip\FamilyEnvolmentGoalsCollection;

class FamilyEnvolmentGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familiEnvolments = FamilyEnvolment::orderBy("id", "desc")
                            ->paginate(10);
                    
        return response()->json([
            "familiEnvolments" => $familiEnvolments ,
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

        $request->request->add(["caregivers_training_goals"=>json_encode($request->caregivers_training_goals)]);
        
        $familiEnvolment = FamilyEnvolment::create($request->all());
               
        return response()->json([
            "message"=>200,
            "id"=>$familiEnvolment->id,
            'familiEnvolment' => new FamilyEnvolmentGoalsResource($familiEnvolment),
            "caregivers_training_goals"=>json_decode($familiEnvolment-> caregivers_training_goals),
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
        $familiEnvolment = FamilyEnvolment::findOrFail($id);

        return response()->json([
            "familiEnvolment" => $familiEnvolment,
            "client_id" => $client_id,
            "caregivers_training_goals"=>json_decode($familiEnvolment-> caregivers_training_goals),
            
        ]);
        
        
    }

    public function showbyProfile($id)
    {
        $patient = FamilyEnvolment::where("client_id","<>", $id)->first();
        return response()->json([
            "patient" => $patient,
        ]);

        
    }


    public function showgbyPatientId($patient_id)
    {
        $familiEnvolmentPatientIds = FamilyEnvolment::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
            "familiEnvolmentPatientIds" => FamilyEnvolmentGoalsCollection::make($familiEnvolmentPatientIds)
            
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
        $familiEnvolment = FamilyEnvolment::findOrFail($id);

        $request->request->add(["caregivers_training_goals"=>json_encode($request->caregivers_training_goals)]);
        
        $familiEnvolment->update($request->all());
        
        return response()->json([
            "message"=>200,
            "familiEnvolment"=>$familiEnvolment,
            "caregivers_training_goals"=>json_decode($familiEnvolment-> caregivers_training_goals),
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
        $familiEnvolment = FamilyEnvolment::findOrFail($id);
        $familiEnvolment->delete();
        return response()->json([
            "message" => 200
        ]);
    }
}
