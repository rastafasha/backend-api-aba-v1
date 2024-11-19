<?php

namespace App\Http\Controllers\Admin\Bip;

use Illuminate\Http\Request;
use App\Models\Bip\CrisisPlan;
use App\Models\Patient\Patient;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bip\CrisisPlanResource;
use App\Http\Resources\Bip\CrisisPlanCollection;

class CrisisPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crisiPlans = CrisisPlan::orderBy("id", "desc")
                            ->paginate(10);

        return response()->json([
            "crisiPlans" => $crisiPlans ,
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

        $request->request->add(["risk_factors" => json_encode($request->risk_factors)]);
        $request->request->add(["suicidalities" => json_encode($request->suicidalities)]);
        $request->request->add(["homicidalities" => json_encode($request->homicidalities)]);


        $crisiPlan = CrisisPlan::create($request->all());


        return response()->json([
            "message" => 200,
            "id" => $crisiPlan->id,
            'crisiPlan' => new CrisisPlanResource($crisiPlan),
            "risk_factors" => json_decode($crisiPlan-> risk_factors),
            "suicidalities" => json_decode($crisiPlan-> suicidalities),
            "homicidalities" => json_decode($crisiPlan-> homicidalities),
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
        $crisiPlan = CrisisPlan::findOrFail($id);

        return response()->json([
            "crisiPlan" => $crisiPlan,
            // "client_id" => $client_id,
            "risk_factors" => json_decode($crisiPlan-> risk_factors),
            "suicidalities" => json_decode($crisiPlan-> suicidalities),
            "homicidalities" => json_decode($crisiPlan-> homicidalities),


        ]);
    }

    public function showbyProfile($id)
    {
        $patient = CrisisPlan::where("client_id", "<>", $id)->first();
        return response()->json([
            "patient" => $patient,
        ]);
    }


    public function showgbyPatientId($patient_id)
    {
        $crisiPlanPatientIds = CrisisPlan::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
            "crisiPlanPatientIds" => CrisisPlanCollection::make($crisiPlanPatientIds)

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
        $crisiPlan = CrisisPlan::findOrFail($id);

        $request->request->add(["risk_factors" => json_encode($request->risk_factors)]);
        $request->request->add(["suicidalities" => json_encode($request->suicidalities)]);
        $request->request->add(["homicidalities" => json_encode($request->homicidalities)]);

        $crisiPlan->update($request->all());

        return response()->json([
            "message" => 200,
            "crisiPlan" => $crisiPlan,
            "risk_factors" => json_decode($crisiPlan-> risk_factors),
            "suicidalities" => json_decode($crisiPlan-> suicidalities),
            "homicidalities" => json_decode($crisiPlan-> homicidalities),
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
        $crisiPlan = CrisisPlan::findOrFail($id);
        $crisiPlan->delete();
        return response()->json([
            "message" => 200
        ]);
    }
}
