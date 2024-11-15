<?php

namespace App\Http\Controllers\Admin\Bip;

use Carbon\Carbon;
use App\Models\Bip\Bip;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Models\Bip\ReductionGoal;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bip\ReductionGoalsResource;
use App\Http\Resources\Bip\ReductionGoalsCollection;

class ReductionGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goals = ReductionGoal::orderBy("id", "desc")
                            ->paginate(10);

        return response()->json([
            "goals" => $goals ,
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
        $patient_is_valid = Patient::where("id", $request->id)->first();

        $request->request->add(["goalstos" => json_encode($request->goalstos)]);
        $request->request->add(["goalltos" => json_encode($request->goalltos)]);


        $reduction_goal = ReductionGoal::create($request->all());


        return response()->json([
            "message" => 200,
            "id" => $reduction_goal->id,
            'reduction_goal' => new ReductionGoalsResource($reduction_goal),
            "goalstos" => json_decode($reduction_goal-> goalstos),
            "goalltos" => json_decode($reduction_goal-> goalltos),
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
        $reduction_goal = ReductionGoal::findOrFail($id);

        return response()->json([
            // "patient" => $patient,
            "reduction_goal" => $reduction_goal,
            "client_id" => $client_id,
            "documents_reviewed" => json_decode($reduction_goal-> documents_reviewed),
            "maladaptives" => json_decode($reduction_goal-> maladaptives),
            "assestment_conducted_options" => json_decode($reduction_goal-> assestment_conducted_options),
            "prevalent_setting_event_and_atecedents" => json_decode($reduction_goal-> prevalent_setting_event_and_atecedents),
            "interventions" => json_decode($reduction_goal-> interventions),
            "goalstos" => json_decode($reduction_goal-> goalstos),
            "goalltos" => json_decode($reduction_goal-> goalltos),

        ]);
    }
    public function showbyProfile($id)
    {
        $patient = Patient::where("id", $id)->first();
        return response()->json([
            "patient" => $patient,
            // "bip" => BipResource::make($bip),
        ]);
    }
    // public function showbyMaladaptive($goal)
    // {
    //     $goalmaladaptives = ReductionGoal::where("goal", $goal)->first();
    //     return response()->json([
    //         "goalmaladaptives" => $goalmaladaptives,
    //     ]);


    // }

    public function query_patient(Request $request)
    {
        $client_id = $request->get("client_id");

        $patient = Patient::where("client_id", $client_id)->first();

        if (!$patient) {
            return response()->json([
                "message" => 403,
            ]);
        }

        return response()->json([
            "message" => 200,
            "id" => $patient->id,
            "name" => $patient->name,
            "surname" => $patient->surname,
            "phone" => $patient->phone,
            "client_id" => $patient->client_id,
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
        // $patient_is_valid = Patient::findOrFail("patient_id", $patient_id)->first();
        // $patient_is_valid = Bip::where("patient_id", "<>", $patient_id)->first();
        // $reduction_id = ReductionGoal::findOrFail("id", $request->id)->first();


        // if($patient_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el patient ya existe'
        //     ]);
        // }

        $reduction_goal = ReductionGoal::findOrFail($id);

        $request->request->add(["goalstos" => json_encode($request->goalstos)]);
        $request->request->add(["goalltos" => json_encode($request->goalltos)]);

        $reduction_goal->update($request->all());

        return response()->json([
            "message" => 200,
            "reduction_goal" => $reduction_goal,
            "goalstos" => json_decode($reduction_goal-> goalstos),
            "goalltos" => json_decode($reduction_goal-> goalltos),
        ]);
    }

    public function updateSto(Request $request, $id)
    {

        $goalstos = ReductionGoal::findOrfail($id);
        $goalstos = $request->request->add(["goalstos" => json_encode($request->goalstos)]);
        $goalstos->update();
        return $goalstos;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $goalreduction = ReductionGoal::findOrFail($id);
        $goalreduction->delete();
        return response()->json([
            "message" => 200
        ]);
    }

    //se obtiene el bip del usuario
    public function showGoalsbBipId(Request $request, string $bip_id)
    {
        $goalreductions = ReductionGoal::where("bip_id", $bip_id)->first();
        // $goalreductions = ReductionGoal::where("goal", "<>", $goal)->where("goal", $request->goal)->first();

        if ($goalreductions) {
            return response()->json([
                "message" => 403,
                "goalreductions" => $goalreductions,
                "message_text" => 'el goal ya existe'
            ]);
        }
        $goalreductions = ReductionGoal::where("bip_id", $bip_id)->first();
        return response()->json([
            // "goalreductions" => $goalreductions,
            "goalreductions" => ReductionGoalsResource::make($goalreductions),
            "goalstos" => json_decode($goalReductionPatientIds->goalstos),
            "goalltos" => json_decode($goalReductionPatientIds->goalltos),
        ]);
    }
    // , $patient_id
    public function showGoalsbyMaladaptive(Request $request, string $maladaptive, string $patient_id,)
    {
        $patient_id = Patient::where("patient_id", $patient_id)->first();
        $patient_is_valid = ReductionGoal::where("patient_id", $patient_id)->first();
        $goalsmaladaptive = ReductionGoal::where("patient_id", $request->patient_id)
        ->where("maladaptive", $maladaptive)
        ->orderBy("id", "desc")
        ->get();

        if (!$goalsmaladaptive) {
            return response()->json([
                "message" => 403,
                "goalsmaladaptive" => $goalsmaladaptive,
                "message_text" => 'no hay goals maladaptativos'
            ]);
        }

        // $goalsmaladaptive = ReductionGoal::where("maladaptive", $maladaptive)
        // ->where("patient_id", $patient_id)
        // ->orderBy("id", "desc")
        // ->get();


        return response()->json([
            // "goal"=>$goal,
            // "patient_id"=>$patient_id,
            "goalsmaladaptive" => ReductionGoalsCollection::make($goalsmaladaptive) ,


        ]);
    }
    public function showgbyPatientId($patient_id)
    {
        $goalReductionPatientIds = ReductionGoal::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();


        return response()->json([
            "goalReductionPatientIds" => ReductionGoalsCollection::make($goalReductionPatientIds) ,
            // "goalReductionPatientIds" => $goalReductionPatientIds ,
            // "goalstos"=>json_decode($goalReductionPatientIds->goalstos),
            // "goalltos"=>json_decode($goalReductionPatientIds->goalltos),


        ]);
    }
}
