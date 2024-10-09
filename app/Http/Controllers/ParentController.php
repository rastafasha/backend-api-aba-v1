<?php

namespace App\Http\Controllers;

use App\Models\Bip\Bip;
use App\Models\Parents;
use Illuminate\Http\Request;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Parent\ParentResource;
use App\Http\Resources\Patient\PatientResource;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parent_is_valid = Parents::where("email", $request->email)->first();

        if($parent_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'the parent with this email already exist'
            ]);
        }
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:parents',
            'patient_id' => 'required|string',
            // ...
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        if($request->password){
            $request->request->add(["password"=>Hash::make($request->password)]);
        }

        $parent = Parents::create($request->all());
        $role = Role::firstOrCreate(['name' => 'PARENT', 'guard_name' => 'apiparent']);
        $parent->assignRole($role);

        return response()->json([
            "message" => 200,
            "parent"=>$parent
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
        $parent = Parents::findOrFail($id);

        return response()->json([
            // "parent" => ParentResource::make($parent),
            "parent" => $parent,
            "documents_pending"=> json_decode($parent-> documents_pending),
        ]);
    }

    public function showWithPatient($id,  $patient_id)
    {
        $parent = Parents::findOrFail($id);
        
        
        $patient = Patient::where('patient_id',$patient_id)->first();

        return response()->json([
            
            "patient"=> PatientResource::make($patient),
            "parent" => $parent,
            "parent"=> $parent ?[
                "id" =>$parent->id,
                "name"=>$parent->name,
                "surname"=>$parent->surname,
                "status"=>$parent->status,
                "patient_id"=>$patient->patient_id,
                "full_name"=> $parent->name.' '.$parent->surname,
                "email"=>$parent->email,
            ]:null,
            
            
        ]);
    }

    public function showWithPatientBip($id,  $patient_id)
    {
        $parent = Parents::findOrFail($id);
        
        $bip = Bip::where("patient_id", $patient_id)->first();
        
        $patient = Patient::where('patient_id',$patient_id)->first();

        return response()->json([
            
            "patient" => $patient,
            "patient"=> $patient ?[
                "id" =>$patient->id,
                "title"=>$patient->patient_id,
                "full_name"=> $patient->first_name.' '.$patient->last_name,
                "email"=>$patient->email,
                "insurer_id"=>$patient->insurer_id,

                "rbt_home" =>$patient->rbt_home_id,
                
                "rbt2_school"=>$patient->rbt2_school_id,
                
                "bcba_home"=>$patient->bcba_home_id,

                "bcba2_school"=>$patient->bcba2_school_id,

                "clin_director_id"=>$patient->clin_director_id,

                "status"=>$patient->status,
                "gender"=>$patient->gender,
                "avatar"=> $patient->avatar ? env("APP_URL")."storage/".$patient->avatar : null,
                // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
            ]:null,
            "bip" => $bip,
            // "bip"=> $bip ?[
            //     "id" =>$patient->id,
            //     "title"=>$patient->patient_id,
            //     "full_name"=> $patient->first_name.' '.$patient->last_name,
            //     "email"=>$patient->email,
            //     "insurer_id"=>$patient->insurer_id,
            //     "rbt_home" =>$patient->rbt_home_id,
            //     "rbt2_school"=>$patient->rbt2_school_id,
            //     "bcba_home"=>$patient->bcba_home_id,
            //     "bcba2_school"=>$patient->bcba2_school_id,
            //     "clin_director_id"=>$patient->clin_director_id,
            //     "status"=>$patient->status,
            //     "gender"=>$patient->gender,
            //     "avatar"=> $patient->avatar ? env("APP_URL")."storage/".$patient->avatar : null,
            //     // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
            // ]:null,
            "parent" => $parent,
            "parent"=> $parent ?[
                "id" =>$parent->id,
                "name"=>$parent->name,
                "surname"=>$parent->surname,
                "status"=>$parent->status,
                "patient_id"=>$patient->patient_id,
                "full_name"=> $parent->name.' '.$parent->surname,
                "email"=>$parent->email,
            ]:null,
            
            
        ]);
    }

    public function showWithPatientRBTNotes($id,  $patient_id)
    {
        $parent = Parents::findOrFail($id);
        
        $notesRbt = NoteRbt::where("patient_id", $patient_id)->first();
        
        $patient = Patient::where('patient_id',$patient_id)->first();

        return response()->json([
            "parent" => $parent,
            "parent"=> $parent ?[
                "id" =>$parent->id,
                "name"=>$parent->name,
                "surname"=>$parent->surname,
                "status"=>$parent->status,
                "patient_id"=>$patient->patient_id,
                "full_name"=> $parent->name.' '.$parent->surname,
                "email"=>$parent->email,
            ]:null,
            "patient" => $patient,
            "patient"=> $patient ?[
                "id" =>$patient->id,
                "title"=>$patient->patient_id,
                "full_name"=> $patient->first_name.' '.$patient->last_name,
                "email"=>$patient->email,
                "insurer_id"=>$patient->insurer_id,

                "rbt_home" =>$patient->rbt_home_id,
                
                "rbt2_school"=>$patient->rbt2_school_id,
                
                "bcba_home"=>$patient->bcba_home_id,

                "bcba2_school"=>$patient->bcba2_school_id,

                "clin_director_id"=>$patient->clin_director_id,

                "status"=>$patient->status,
                "gender"=>$patient->gender,
                "avatar"=> $patient->avatar ? env("APP_URL")."storage/".$patient->avatar : null,
                // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
            ]:null,

            
            "notesRbt" => $notesRbt,
            
            
        ]);
    }

    public function showWithPatientRBTNotesRecents($id,  $patient_id)
    {
        $parent = Parents::findOrFail($id);
        
        $notesRbt = NoteRbt::where("patient_id", $patient_id)
        ->orderBy('created_at', 'DESC')
        ->first();
        
        $patient = Patient::where('patient_id',$patient_id)->first();

        return response()->json([
            
            "notesRbt" => $notesRbt,
            "notesRbt"=> $notesRbt ?[
                "id" =>$notesRbt->id,
                "session_date"=>$notesRbt->session_date,
                "status"=>$notesRbt->status,
                "pos"=>$notesRbt->pos,
            ]:null,
            
            
        ]);
    }

    public function showWithPatientBCBANotes($id,  $patient_id)
    {
        $parent = Parents::findOrFail($id);
        
        $notesBcba = NoteBcba::where("patient_id", $patient_id)->first();
        
        $patient = Patient::where('patient_id',$patient_id)->first();

        return response()->json([
            "parent" => $parent,
            "parent"=> $parent ?[
                "id" =>$parent->id,
                "name"=>$parent->name,
                "surname"=>$parent->surname,
                "status"=>$parent->status,
                "patient_id"=>$patient->patient_id,
                "full_name"=> $parent->name.' '.$parent->surname,
                "email"=>$parent->email,
            ]:null,
            "patient" => $patient,
            "patient"=> $patient ?[
                "id" =>$patient->id,
                "title"=>$patient->patient_id,
                "full_name"=> $patient->first_name.' '.$patient->last_name,
                "email"=>$patient->email,
                "insurer_id"=>$patient->insurer_id,

                "rbt_home" =>$patient->rbt_home_id,
                
                "rbt2_school"=>$patient->rbt2_school_id,
                
                "bcba_home"=>$patient->bcba_home_id,

                "bcba2_school"=>$patient->bcba2_school_id,

                "clin_director_id"=>$patient->clin_director_id,

                "status"=>$patient->status,
                "gender"=>$patient->gender,
                "avatar"=> $patient->avatar ? env("APP_URL")."storage/".$patient->avatar : null,
                // "avatar"=> $patient->avatar ? env("APP_URL").$patient->avatar : null,
            ]:null,

            
            "notesBcba" => $notesBcba,
            
            
        ]);
    }

    public function showWithPatientBCBANotesRecent($id,  $patient_id)
    {
        $parent = Parents::findOrFail($id);
        
        $notesBcba = NoteBcba::where("patient_id", $patient_id)
        ->orderBy('created_at', 'DESC')
        ->first();
        
        $patient = Patient::where('patient_id',$patient_id)->first();

        return response()->json([
            "notesBcba" => $notesBcba,
            "notesBcba"=> $notesBcba ?[
                "id" =>$notesBcba->id,
                "session_date"=>$notesBcba->session_date,
                "status"=>$notesBcba->status,
                "pos"=>$notesBcba->pos,
            ]:null,
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
        // $parent_is_valid = Parents::where("id", "<>", $id)->first();

        // if($parent_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el parent ya existe'
        //     ]);
        // }

        
        
        $parent = Parents::findOrFail($id);
        if($request->hasFile('imagen')){
            if($parent->avatar){
                Storage::delete($parent->avatar);
            }
            $path = Storage::putFile("parents", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        
        
        $parent->update($request->all());

        return response()->json([
            "message"=>200,
            "parent"=>$parent
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
        $patient = Patient::findOrFail($id);
        if($patient->avatar){
            Storage::delete($patient->avatar);
        }
        //uso de redis
        // $cachedRecord = Redis::get('profile_patient_#'.$id);
        // if(isset($cachedRecord)) {
        //     Redis::del('profile_patient_#'.$id);
        // }
        $patient->delete();
        return response()->json([
            "message"=>200
        ]);
    }
}
