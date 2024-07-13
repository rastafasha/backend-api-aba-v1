<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Patient\PatientResource;
use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Patient\PatientCollection;
use App\Http\Resources\Location\LocationCollection;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client_id = $request->client_id;
        $name_client = $request->search;
        $email_client = $request->search;
        $doctor_id = $request->doctor_id;
        $name_doctor = $request->search;
        $email_doctor = $request->search;

        $locations = Location::filterAdvanceLocation(
            $client_id, $name_client, $email_client,
            $doctor_id, $name_doctor, $email_doctor,
            )->orderBy("id", "desc")
                            ->paginate(10);
        return response()->json([
            // "total"=>$patients->total(),
            "locations"=> LocationCollection::make($locations)
        ]);

    }

    public function config()
    {
        // $roles = Role::where("name","like","%DOCTOR%")->get();
        // $specialists = User::where("status",'active')->get();
        
        
        
        return response()->json([
            // "specialists" => $specialists,
            // "patients" => $patients,
            
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
        $user_is_valid = User::where("email", $request->email)->first();


        if($user_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'el usuario con este email ya existe'
            ]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("locations", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        $location = Location::create($request->all());
        
        
        return response()->json([
            "message"=>200,
            // "location" => LocationCollection::make($location),
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
        
        $patients = Patient::where("location_id",$id)->get();
        // $location = Location::with('specialists', 'patients')->findOrFail($id);
        $location = Location::findOrFail($id);
        // $location1 = $location->doctor;

        // $location = Location::join('users', 'locations.id', '=', 'users.location_id')
        // ->select(
        //     'locations.id as id',
        //     'users.name'
        //     )
        // ->where('locations.id','=', $id)
        // ->get();


        $users = DB::table('users')
            ->join('user_locations', 'users.id', '=', 'user_locations.user_id')
            ->where('user_locations.location_id', $id)
            ->pluck('users.id') // Extraer solo las IDs de usuarios
            ->toArray(); // Convertir la colección en un array

        $specialists = User::whereIn('id', $users)->get();


        return response()->json([
            "location" => LocationResource::make($location),

            
            "specialists"=>$specialists->map(function($specialist){
                return[
                                "id"=> $specialist->id,
                                "full_name"=> $specialist->name.' '.$specialist->surname,
                                "email"=> $specialist->email,
                                "status"=> $specialist->status,
                                "npi"=> $specialist->npi,
                                "phone"=> $specialist->phone,
                                "location_id"=> $specialist->location_id,
                                "roles"=> $specialist->roles,
                                "created_at"=> $specialist->created_at->format('Y-m-d'),
                                "avatar"=> $specialist->avatar ? env("APP_URL")."storage/".$specialist->avatar : null,
                                // "avatar"=> $specialist->avatar ? env("APP_URL").$specialist->avatar : null,
                                
                            ];
                        }),
            "patients" => PatientCollection::make($patients),
            "patients"=>$patients->map(function($patient){
                return[
                    "id"=> $patient->id,
                    "patient_id"=> $patient->patient_id,
                    "full_name"=> $patient->first_name.' '.$patient->last_name,
                    "patient_id"=>$patient->patient_id,

                    "first_name"=>$patient->first_name,
                    "last_name"=>$patient->last_name,
                    "email"=>$patient->email,
                    "phone"=>$patient->phone,
                    "avatar"=> $patient->avatar ? env("APP_URL")."storage/".$patient->avatar : null,
                    // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
                    "status"=> $patient->status,
                    "eligibility"=> $patient->eligibility,
                    "created_at"=> $patient->created_at->format('Y-m-d'),

                    "rbt_id"=>$patient->rbt_id,
                    "rbt2_id"=>$patient->rbt2_id,
                    "bcba_id"=>$patient->bcba_id,
                    "bcba2_id"=>$patient->bcba2_id,
                ];
            }),
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

        
        $user_is_valid = User::where("email", $request->email)->first();


        // if($user_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el usuario con este email ya existe'
        //     ]);
        // }
        
        $request->request->add(["pa_services"=>json_encode($request->services)]);
        $request->request->add(["pa_assessments"=>json_encode($request->pa_assessments)]);

        
        
        $location = Location::findOrFail($id);

        if($request->hasFile('imagen')){
            if($location->avatar){
                Storage::delete($location->avatar);
            }
            $path = Storage::putFile("locations", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        
       
        $location->update($request->all());
        
        
        return response()->json([
            "message"=>200,
            "location"=>$location,
            // "assesstments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : [],
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
        $location = Location::findOrFail($id);
        if($location->avatar){
            Storage::delete($location->avatar);
        }
        $location->delete();
        return response()->json([
            "message"=>200
        ]);
    }
}
