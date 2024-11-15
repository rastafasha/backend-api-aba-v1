<?php

namespace App\Http\Controllers\Admin\Bip;

use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Http\Controllers\Controller;
use App\Models\Bip\GeneralizationTraining;
use App\Http\Resources\Bip\GeneralizationTrainingResource;
use App\Http\Resources\Bip\GeneralizationTrainingCollection;

class GeneralizationTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generalizationTrainings = GeneralizationTraining::orderBy("id", "desc")
                            ->paginate(10);

        return response()->json([
            "generalizationTrainings" => $generalizationTrainings ,
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

        $request->request->add(["transition_fading_plans" => json_encode($request->transition_fading_plans)]);


        $generalizationTraining = GeneralizationTraining::create($request->all());


        return response()->json([
            "message" => 200,
            "id" => $generalizationTraining->id,
            'generalizationTraining' => new GeneralizationTrainingResource($generalizationTraining),
            "transition_fading_plans" => json_decode($generalizationTraining-> transition_fading_plans),
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
        $generalizationTraining = GeneralizationTraining::findOrFail($id);

        return response()->json([
            "generalizationTraining" => $generalizationTraining,
            "client_id" => $client_id,
            "transition_fading_plans" => json_decode($generalizationTraining-> transition_fading_plans),

        ]);
    }

    public function showbyProfile($id)
    {
        $patient = GeneralizationTraining::where("client_id", "<>", $id)->first();
        return response()->json([
            "patient" => $patient,
        ]);
    }


    public function showgbyPatientId($patient_id)
    {
        $generalizationTrainingPatientIds = GeneralizationTraining::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
            "generalizationTrainingPatientIds" => GeneralizationTrainingCollection::make($generalizationTrainingPatientIds)

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
        $generalizationTraining = GeneralizationTraining::findOrFail($id);

        $request->request->add(["transition_fading_plans" => json_encode($request->transition_fading_plans)]);

        $generalizationTraining->update($request->all());

        return response()->json([
            "message" => 200,
            "generalizationTraining" => $generalizationTraining,
            "transition_fading_plans" => json_decode($generalizationTraining-> transition_fading_plans),
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
        $generalizationTraining = GeneralizationTraining::findOrFail($id);
        $generalizationTraining->delete();
        return response()->json([
            "message" => 200
        ]);
    }
}
