<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Insurance\Insurance;
use App\Http\Controllers\Controller;
use App\Http\Resources\Insurance\InsuranceResource;
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
        $request->request->add(["services"=>json_encode($request->services)]);
        $request->request->add(["notes"=>json_encode($request->notes)]);

        $insurance = Insurance::create($request->all());
        
            return response()->json([
            "message"=>200,
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
            "id"=>$insurance->id,
            "insurer_name"=>$insurance->insurer_name,
            "services"=>json_decode($insurance-> services),
            "notes"=>json_decode($insurance-> notes)
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

        $request->request->add(["services"=>json_encode($request->services)]);
        $request->request->add(["notes"=>json_encode($request->notes)]);
        $insurance = Insurance::findOrFail($id);

        $insurance->update($request->all());

        return response()->json([
            "message"=>200,
            "insurance"=>$insurance
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
}
