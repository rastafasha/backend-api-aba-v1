<?php

namespace App\Http\Controllers\Admin\Bip;

use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Http\Controllers\Controller;
use App\Models\Bip\DeEscalationTechnique;
use App\Http\Resources\Bip\DeEscalationTechniqueResource;
use App\Http\Resources\Bip\DeEscalationTechniqueCollection;

class DeEscalationTechniqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deEscalationTechniques = DeEscalationTechnique::orderBy("id", "desc")
                            ->paginate(10);
                    
        return response()->json([
            "deEscalationTechniques" => $deEscalationTechniques ,
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

        $request->request->add(["recomendation_lists"=>json_encode($request->recomendation_lists)]);
        

        $deEscalationTechnique = DeEscalationTechnique::create($request->all());
        
        
        return response()->json([
            "message"=>200,
            "id"=>$deEscalationTechnique->id,
            'deEscalationTechnique' => new DeEscalationTechniqueResource($deEscalationTechnique),
            "recomendation_lists"=>json_decode($deEscalationTechnique-> recomendation_lists),
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
        $deEscalationTechnique = DeEscalationTechnique::findOrFail($id);

        return response()->json([
            "deEscalationTechnique" => $deEscalationTechnique,
            "client_id" => $client_id,
            "recomendation_lists"=>json_decode($deEscalationTechnique-> recomendation_lists),
            
        ]);
    }

    public function showbyProfile($id)
    {
        $patient = DeEscalationTechnique::where("client_id","<>", $id)->first();
        return response()->json([
            "patient" => $patient,
        ]);

        
    }


    public function showgbyPatientId($patient_id)
    {
        $deEscalationTechniquePatientIds = DeEscalationTechnique::where("patient_id", $patient_id)->orderBy("patient_id", "desc")->get();
        return response()->json([
            "deEscalationTechniquePatientIds" => DeEscalationTechniqueCollection::make($deEscalationTechniquePatientIds)
            
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
        $deEscalationTechnique = DeEscalationTechnique::findOrFail($id);

        $request->request->add(["recomendation_lists"=>json_encode($request->recomendation_lists)]);
        
        $deEscalationTechnique->update($request->all());
        
        return response()->json([
            "message"=>200,
            "deEscalationTechnique"=>$deEscalationTechnique,
            "recomendation_lists"=>json_decode($deEscalationTechnique-> recomendation_lists),
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
        $deEscalationTechnique = DeEscalationTechnique::findOrFail($id);
        $deEscalationTechnique->delete();
        return response()->json([
            "message" => 200
        ]);
    }
}
