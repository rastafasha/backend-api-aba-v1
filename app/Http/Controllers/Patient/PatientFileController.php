<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Models\Patient\PatientFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Patient\PatientFileResource;
use App\Http\Resources\Patient\PatientFileCollection;

class PatientFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $speciality_id = $request->speciality_id;
        // $name_doctor = $request->search;
        // $date = $request->date;
        //
        // $appointments = Appointment::filterAdvance($speciality_id, $name_doctor, $date)
        //                     ->orderBy("id", "desc")
        //                     ->where("status", 2)
        //                     ->paginate(10);
        // return response()->json([
        //     "total"=>$appointments->total(),
        //     "appointments"=> AppointmentCollection::make($appointments)
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $appointment = Appointment::findOrFail($request->appointment_id);

        $user_is_valid = PatientFile::where("patient_id", "<>", $request->patient_id)->first();

        if ($user_is_valid) {
            return response()->json([
                "message" => 403,
                "message_text" => 'el Paciente ya existe'
            ]);
        }

        foreach ($request->file("files") as $key => $file) {
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $name_file = $file->getClientOriginalName();
            $data = null;
            if (in_array(strtolower($extension), ["jpeg", "bmp","jpg","png", "pdf" ])) {
                $data = getImageSize($file);
            }
            $path = Storage::putFile("patientFiles", $file);

            $patientFile = PatientFile::create([
                'patient_id' => $request->patient_id,
                'name_file' => $name_file,
                'size' => $size,
                'resolution' => $data ? $data[0] . "x" . $data[1] : null,
                'file' => $path,
                'type'  => $extension,
            ]);
        }

        // error_log($clase);
        error_log($patientFile);

        return response()->json([ 'patientFile' => PatientFileResource::make($patientFile)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $patient_id
     * @return \Illuminate\Http\Response
     */


    public function showByPatient($patient_id)
    {
        $patientFiles = PatientFile::where("patient_id", $patient_id)->get();

        return response()->json([
            "patientFiles" => PatientFileCollection::make($patientFiles),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $patientFile = PatientFile::findOrFail($id);
        $patientFile->update($request ->all());

        return response()->json([
            'patientFile' => PatientFileResource::make($patientFile)
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patientFile = PatientFile::findOrFail($id);
        $patientFile->delete();

        return response()->json([
            "message" => 200
        ]);
    }
}
