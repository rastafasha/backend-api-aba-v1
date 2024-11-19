<?php

namespace App\Http\Controllers\Admin\Bip;

use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Http\Controllers\Controller;
use App\Models\Bip\MonitoringEvaluating;
use App\Http\Resources\Bip\MonitoringEvaluatingResource;
use App\Http\Resources\Bip\MonitoringEvaluatingCollection;

class MonitoringEvaluatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $monitoringEvaluatings = MonitoringEvaluating::orderBy("id", "desc")
                            ->paginate(10);

        return response()->json([
            "monitoringEvaluatings" => $monitoringEvaluatings ,
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

        $request->request->add(["rbt_training_goals" => json_encode($request->rbt_training_goals)]);

        $monitoringEvaluating = MonitoringEvaluating::create($request->all());

        return response()->json([
            "message" => 200,
            "id" => $monitoringEvaluating->id,
            'monitoringEvaluating' => new MonitoringEvaluatingResource($monitoringEvaluating),
            "rbt_training_goals" => json_decode($monitoringEvaluating-> rbt_training_goals),
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
        $monitoringEvaluating = MonitoringEvaluating::findOrFail($id);

        return response()->json([
            "monitoringEvaluating" => $monitoringEvaluating,
            "client_id" => $client_id,
            "rbt_training_goals" => json_decode($monitoringEvaluating-> rbt_training_goals),

        ]);
    }

    public function showbyProfile($id)
    {
        $patient = MonitoringEvaluating::where("client_id", "<>", $id)->first();
        return response()->json([
            "patient" => $patient,
        ]);
    }


    public function showgbyPatientId($patient_id)
    {
        $monitoringEvaluatingPatientIds = MonitoringEvaluating::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
            "monitoringEvaluatingPatientIds" => MonitoringEvaluatingCollection::make($monitoringEvaluatingPatientIds)

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
        $monitoringEvaluating = MonitoringEvaluating::findOrFail($id);

        $request->request->add(["rbt_training_goals" => json_encode($request->rbt_training_goals)]);

        $monitoringEvaluating->update($request->all());

        return response()->json([
            "message" => 200,
            "monitoringEvaluating" => $monitoringEvaluating,
            "rbt_training_goals" => json_decode($monitoringEvaluating-> rbt_training_goals),
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
        $monitoringEvaluating = MonitoringEvaluating::findOrFail($id);
        $monitoringEvaluating->delete();
        return response()->json([
            "message" => 200
        ]);
    }
}
