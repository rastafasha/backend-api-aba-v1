<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Insurance\Insurance;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\Insurance\InsuranceCollection;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $insurer_name = $request->insurer_name;

        // $payments = Payment::where("referencia","like","%".$referencia."%")
        // ->orderBy("id","desc")
        // ->paginate(10);
        // // ->get();

        $insurances = Insurance::filterAdvanceInsurance($insurer_name)->orderBy("id", "desc")
                            ->paginate(10);

        return response()->json([
            // "total"=>$payments->total(),
            "insurances" => InsuranceCollection::make($insurances) ,

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
        $request->request->add(["services" => $request->services]);
        $request->request->add(["notes" => $request->notes]);

        $insurance = Insurance::create($request->all());

            return response()->json([
            "message" => 200,
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function show(string $id)
    {
        $insurance = Insurance::findOrFail($id);
        return response()->json([
            "id" => $insurance->id,
            // "name" => $insurance->name,
            "insurance" => $insurance,
            "services" => $insurance-> services,
            "notes" => $insurance-> notes
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

        $request->request->add(["services" => $request->services]);
        $request->request->add(["notes" => $request->notes]);
        $insurance = Insurance::findOrFail($id);

        $insurance->update($request->all());

        return response()->json([
            "message" => 200,
            "insurance" => $insurance
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
        $insurance = Insurance::findOrFail($id);
        $insurance->delete();
        return response()->json([
            "message" => 200
        ]);
    }
    //
    public function showInsuranceCpt(Request $request, string $insurer_name, string $code, string $provider)
    {
        // $patient_id = Patient::where("patient_id", $patient_id)->first();
        // $codes = Insurance::where("insurer_name", $insurer_name)
        // ->where("services", $code)->first();

        $insurance = Insurance::where("name", $insurer_name)
        ->where("services", "like", "%" . $code . "%")
        ->where("services", "like", "%" . $provider . "%")
        ->first();

        // $insurance = Insurance::where([
        //     "insurer_name" => $insurer_name,
        //     "services" => [
        //         "like" => "%". $code. "%",
        //         // "like" => "%". $provider. "%"
        //     ]
        // ])->first();

        if ($insurance) {
            Log::info("Insurance data found");
            $services = $insurance->services;
            $unit_prize = null; // Define $unit_prize here
            if (is_array($services)) {
                foreach ($services as $service) {
                    if ($service['code'] == $code && $service['provider'] == $provider) {
                        $unit_prize = $service['unit_prize'];
                        break;
                    }
                }
            }
        } else {
            Log::error("Insurance data not found");
            Log::info("Query: " . Insurance::where([
                "name" => $insurer_name,
                "services" => [
                    "like" => "%" . $code . "%",
                    "like" => "%" . $provider . "%"
                ]
            ])->toSql());
            throw new \Exception("Insurance data not found");
        }

        return response()->json([
            "code" => $code,
            "provider" => $provider,
            "unit_prize" => $unit_prize,
            "name" => $insurance->name
        ]);
    }
}
