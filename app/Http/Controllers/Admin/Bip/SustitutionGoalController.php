<?php

namespace App\Http\Controllers\Admin\Bip;

use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Models\Bip\SustitutionGoal;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bip\SustitutionGoalsResource;
use App\Http\Resources\Bip\SustitutionGoalsCollection;

class SustitutionGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sustitutiongoals = SustitutionGoal::orderBy("id", "desc")
                            ->paginate(10);

        return response()->json([
            "sustitutiongoals" => $sustitutiongoals ,
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


        $sustitutiongoal = SustitutionGoal::create($request->all());


        return response()->json([
            "message" => 200,
            "id" => $sustitutiongoal->id,
            'sustitutiongoal' => new SustitutionGoalsResource($sustitutiongoal),
            "goalstos" => json_decode($sustitutiongoal-> goalstos),
            "goalltos" => json_decode($sustitutiongoal-> goalltos),
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
        $sustitutiongoal = SustitutionGoal::findOrFail($id);

        return response()->json([
            "sustitutiongoal" => $sustitutiongoal,
            // "client_id" => $client_id,
            "goalstos" => json_decode($sustitutiongoal-> goalstos),
            "goalltos" => json_decode($sustitutiongoal-> goalltos),

        ]);
    }

    public function showbyProfile($id)
    {
        $patient = Patient::where("id", $id)->first();
        return response()->json([
            "patient" => $patient,
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
        $sustitutiongoal = SustitutionGoal::findOrFail($id);

        $request->request->add(["goalstos" => json_encode($request->goalstos)]);
        $request->request->add(["goalltos" => json_encode($request->goalltos)]);

        $sustitutiongoal->update($request->all());

        return response()->json([
            "message" => 200,
            "sustitutiongoal" => $sustitutiongoal,
            "goalstos" => json_decode($sustitutiongoal-> goalstos),
            "goalltos" => json_decode($sustitutiongoal-> goalltos),
        ]);
    }

    public function updateSto(Request $request, $id)
    {

        $goalstos = SustitutionGoal::findOrfail($id);
         $request->request->add(["goalstos" => json_encode($request->goalstos)]);

        $goalstos->update($request->all());
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
        $sustitutiongoal = SustitutionGoal::findOrFail($id);
        $sustitutiongoal->delete();
        return response()->json([
            "message" => 200
        ]);
    }


    public function showGoalsbyGoal(Request $request, string $goal)
    {
        $patient_is_valid = Patient::where("patient_identifier", '<>', $request->patient_identifier)->first();

        // if($patient_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el usuario existe'
        //     ]);
        // }

        $sustitutiongoal = SustitutionGoal::where("goal", $goal)->orderBy("id", "desc")->get();
        return response()->json([
            "sustitutiongoalmaladaptive" => SustitutionGoalsCollection::make($sustitutiongoal) ,
        ]);
    }
    public function showgbyPatientId($patient_identifier)
    {
        $sustitutiongoalPatientIds = SustitutionGoal::where("patient_identifier", $patient_identifier)->orderBy("patient_identifier", "desc")->get();
        return response()->json([
            "sustitutiongoalPatientIds" => SustitutionGoalsCollection::make($sustitutiongoalPatientIds)

        ]);
    }


    public function showInsuranceCpt(Request $request, string $insurer_name, string $code, $patient_identifier)
    {
        // $patient_identifier = Patient::where("patient_identifier", $patient_identifier)->first();
        // $codes = Insurance::where("insurer_name", $insurer_name)
        // ->where("services", $code)->first();

        $goalSto = SustitutionGoal::where("insurer_name", $insurer_name)
        ->where("services", "like", "%" . $code . "%")
        ->first();

        if ($goalSto) {
            $services = json_decode($goalSto->services, true);
            $unit_prize = isset($services['unit_prize']) ? $services['unit_prize'] : null;
        } else {
            $unit_prize = null;
        }

        return response()->json([
            // "goal"=>$goal,
            // "patient_identifier"=>$patient_identifier,
            "code" => $code,
            "unit_prize" => $unit_prize,
            "goalSto" => $goalSto,


        ]);
    }

    // trae el STO del goal cuando  sustitution_status_sto es igual a inprogress, pero solo trae uno
    public function showgbyPatientIdFilterGoal(Request $request, string $goal)
    {
        $goal = SustitutionGoal::where("goal", $goal)->first();

        $goalstos = json_decode($goal->goalstos, true);

        $stoInprogress = array_filter($goalstos, function ($sto) {
            return $sto['sustitution_status_sto'] === 'inprogress' && $sto['sustitution_status_sto_edit'] === 'inprogress';
        });


        return response()->json([
           //  "goal" => $goal->goal,
            "goalstos" => [
               //  "all" => $goal->goalstos,
                "in_progress" => $stoInprogress, // Agrega ->all() para obtener los resultados
               //  "status" => $goal->goalstos->sustitution_status_sto,
            ],
        ]);
    }

     // trae todos los stos de todos los goals del paciente, donde sustitution_status_sto sean iguales a  inprogress
    public function showgbyPatientIdFilterGoalAll(
        Request $request,
        string $patient_identifier,
        string $insurer_name,
        string $goal,
        string $code
    ) {
        $goals = SustitutionGoal::where("patient_identifier", $patient_identifier)
        ->where("insurer_name", $insurer_name)
        ->where("goal", $goal)
        ->where("code", $code)
        ->get();
    }
}
