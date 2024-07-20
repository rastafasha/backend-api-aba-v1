<?php

namespace App\Http\Controllers\Admin\Bip;

use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Http\Controllers\Controller;
use App\Models\Bip\BehaviorAsistant;
use App\Http\Resources\Bip\BehaviorAsistantResource;
use App\Http\Resources\Bip\BehaviorAsistantCollection;

class BehviorAsistantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $behaviorAsistants = BehaviorAsistant::orderBy("id", "desc")
        ->paginate(10);

        return response()->json([
        "behaviorAsistants" => $behaviorAsistants ,
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

        $request->request->add(["behavior_assistant_work_schedule"=>json_encode($request->behavior_assistant_work_schedule)]);
        

        $behaviorAsistant = BehaviorAsistant::create($request->all());
        
        
        return response()->json([
            "message"=>200,
            "id"=>$behaviorAsistant->id,
            'behaviorAsistant' => new BehaviorAsistantResource($behaviorAsistant),
            "behavior_assistant_work_schedule"=>json_decode($behaviorAsistant-> behavior_assistant_work_schedule),
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
        $behaviorAsistant = BehaviorAsistant::findOrFail($id);

        return response()->json([
            "behaviorAsistant" => $behaviorAsistant,
            "client_id" => $client_id,
            "behavior_assistant_work_schedule"=>json_decode($behaviorAsistant-> behavior_assistant_work_schedule),
            
        ]);
    }

    public function showbyProfile($id)
    {
        $patient = BehaviorAsistant::where("client_id","<>", $id)->first();
        return response()->json([
            "patient" => $patient,
        ]);

        
    }


    public function showgbyPatientId($patient_id)
    {
        $behaviorAsistantPatientIds = BehaviorAsistant::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
            "behaviorAsistantPatientIds" => BehaviorAsistantCollection::make($behaviorAsistantPatientIds)
            
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
       $behaviorAsistant = BehaviorAsistant::findOrFail($id);

        $request->request->add(["behavior_assistant_work_schedule"=>json_encode($request->behavior_assistant_work_schedule)]);
        
        $behaviorAsistant->update($request->all());
        
        return response()->json([
            "message"=>200,
            "behaviorAsistant"=>$behaviorAsistant,
            "behavior_assistant_work_schedule"=>json_decode($behaviorAsistant-> behavior_assistant_work_schedule),
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
        $behaviorAsistant = BehaviorAsistant::findOrFail($id);
        $behaviorAsistant->delete();
        return response()->json([
            "message" => 200
        ]);
    }
}
