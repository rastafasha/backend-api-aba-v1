<?php

namespace App\Http\Controllers\Admin\Billing;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use App\Models\Insurance\Insurance;
use App\Models\PaService;
use App\Http\Controllers\Controller;
use App\Models\Billing\ClientReport;
use App\Http\Resources\Bip\BipResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Note\NoteRbtResource;
use App\Http\Resources\Note\NoteRbtCollection;
use App\Http\Resources\Billing\BillingResource;
use App\Http\Resources\Note\NoteBcbaCollection;
use App\Http\Resources\Billing\BillingCollection;
use App\Http\Resources\Insurance\InsuranceCollection;
use App\Http\Resources\Billing\ClientReport\ClientReportCollection;

class ClientReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search_doctor = $request->search_doctor;
        $search_tecnicoRbt = $request->search_tecnicoRbt;
        $search_supervisor = $request->search_supervisor;
        // $search_patient = $request->search_patient;
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $clientReports = NoteRbt::filterAdvanceClientReport(
            $search_doctor,
            $search_tecnicoRbt,
            $search_supervisor,
            // $search_patient,
            $date_start,
            $date_end
        )
            ->paginate(10);
        return response()->json([
            "total" => $clientReports->total(),
            "clientReports" => NoteRbtCollection::make($clientReports)
        ]);
    }



    public function config()
    {

        $insurances = Insurance::get();
        $users = User::orderBy("id", "desc")->get();

        return response()->json([
            // "insurances"=>$users,
            "doctors" => UserCollection::make($users),
            "doctors" => $users->map(function ($user) {
                return [
                    "id" => $user->id,
                    "name" => $user->name,
                    "surname" => $user->surname,
                    "full_name" => $user->name . ' ' . $user->surname,
                    "npi" => $user->npi,
                ];
            }),
            "insurances" => $insurances,
            "insurances" => InsuranceCollection::make($insurances),
            "insurances" => $insurances->map(function ($insurance) {
                return [
                    "id" => $insurance->id,
                    "insurer_name" => $insurance->insurer_name,
                    "services" => is_string($insurance->services)
                            ? json_decode($insurance->services)
                            : $insurance->services,
                    "notes" => is_string($insurance->notes)
                            ? json_decode($insurance->notes)
                            : $insurance->notes,
                        ];
            }),

        ]);
    }



    // mostrar data por el paciente

    public function showByPatientId(Request $request)
    {

        $size_pagination = 50;
        $name_doctor = $request->search;
        $session_date = $request->session_date;
        $patient_identifier = $request->patient_identifier;
        $id = $request->provider_id;
        $provider_id = $request->provider_id;
        $supervisor_name = $request->supervisor_name;

        $patient = Patient::where("patient_identifier", $patient_identifier)->first();

        $startDate = $request->date_start;
        $endDate = $request->date_end;

        $noteBcba = NoteBcba::where("patient_id", $patient->id);
        $noteRbt = NoteRbt::where("patient_id", $patient->id);
        if ($startDate && $endDate) {
            $noteBcba->whereBetween('session_date', [$startDate, $endDate]);
            $noteRbt->whereBetween('session_date', [$startDate, $endDate]);
        }

        $totalRbt = $noteRbt->count();
        $totalBcba = $noteBcba->count();

        if ($request->noteType === 'bcba') {
            $maxCant = $totalBcba;
        } elseif ($request->noteType === 'rbt') {
            $maxCant = $totalRbt;
        } else {
            $maxCant = $totalBcba > $totalRbt ? $totalBcba : $totalRbt;
        }

        $pages = floor($maxCant / $size_pagination);
        $remainder = $maxCant % $size_pagination;
        $pages = $remainder > 0 ? $pages + 1 : $pages;
        $arrayPages = [];
        for ($i = 1; $i <= $pages; $i++) {
            $arrayPages[] = $i;
        }

        if ($request->noteType === 'bcba' || !$request->noteType) {
            $noteBcba = $noteBcba->orderBy('session_date', 'desc')->paginate($size_pagination);
        }
        if ($request->noteType === 'rbt' || !$request->noteType) {
            $noteRbt = $noteRbt->orderBy('session_date', 'desc')->paginate($size_pagination);
        }

        $tecnicoRbts = NoteRbt::where("patient_id", $patient->id)
            ->with('doctor', 'desc')
            ->where('provider_id', $id)
            ->orderby('session_date', 'desc')
            ->get();

        $doctors = Patient::join('users', 'patients.id', '=', 'users.id')
            ->select(
                'patients.id as id',
                'users.name',
            )
            ->get();


        $doctor = NoteRbt::where("provider_id", $provider_id)->get();
        $tecnicoRbts = NoteRbt::where("provider_id", $provider_id)->get();
        $supervisor = NoteRbt::where("supervisor_name", $supervisor_name)->get();

        // if ($request->{'xe'}) {
        //     $request->request->add($xe);
        // }


        $notes = [];

        foreach ($noteRbt as $note) {
            /*Session 1*/
            $timeIn = Carbon::parse($note->time_in);
            $timeOut = Carbon::parse($note->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($note->time_in2);
            $timeOut2 = Carbon::parse($note->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15);

            /*Costo por unidad*/
            // $costoUnidad = 12.51;

            /*Pagar*/
            // $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo

            $notes[] = [
                'id' => $note->id,
                // 'Doctor id' => $note->doctor_id,
                'patient_id' => $note->patient_id,
                'bip_id' => $note->bip_id,
                'supervisor' => $note->supervisor_name,
                'supervisor' => $note->supervisor,
                'supervisor' => [
                    'name' => $note->supervisor->name,
                    'surname' => $note->supervisor->surname,
                    'npi' => $note->supervisor->npi,
                ],
                'tecnicoRbts' => $note->provider_id,
                'tecnicoRbt' => $note->tecnicoRbt,
                'tecnicoRbt' => [
                    'name' => $note->tecnicoRbt->name,
                    'surname' => $note->tecnicoRbt->surname,
                    'npi' => $note->tecnicoRbt->npi,
                ],


                'pos' => $note->pos,
                'session_date' => $note->session_date,
                'meet_with_client_at' => $note->meet_with_client_at,
                'time_in' => $note->time_in,
                'time_out' => $note->time_out,
                'time_in2' => $note->time_in2,
                'time_out2' => $note->time_out2,
                "total_hours" =>
                date("H:i", strtotime($note->time_out) - strtotime($note->time_in) + strtotime($note->time_out2) - strtotime($note->time_in2)),

                'cpt_code' => $note->cpt_code,
                'md' => $note->md,
                'md2' => $note->md2,

                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,
                'billed' => $note->billed,
                'pay' => $note->pay,
                'status' => $note->status,
                'created_at' => $note->created_at,

                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,

            ];
        }

        $notesBcbas = [];

        foreach ($noteBcba as $notebcba) {
            /*Session 1*/
            $timeIn = Carbon::parse($notebcba->time_in);
            $timeOut = Carbon::parse($notebcba->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($notebcba->time_in2);
            $timeOut2 = Carbon::parse($notebcba->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15);

            /*Costo por unidad*/
            // $costoUnidad = 12.51;

            /*Pagar*/
            // $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo


            $notesBcbas[] = [
                'id' => $notebcba->id,
                // 'Doctor id' => $note->doctor_id,
                'patient_id' => $notebcba->patient_id,
                'bip_id' => $notebcba->bip_id,
                "cpt_code" => $notebcba->cpt_code,
                "provider_name" => $notebcba->provider_name,
                "session_date" => $notebcba->session_date,
                'tecnico' => $notebcba->tecnico,
                // 'time_in' => $noteBcba->time_in,
                // 'time_out' => $noteBcba->time_out,
                // 'time_in2' => $noteBcba->time_in2,
                // 'time_out2' => $noteBcba->time_out2,
                "total_hours" =>
                date("H:i", strtotime($notebcba->time_out) - strtotime($notebcba->time_in) + strtotime($notebcba->time_out2) - strtotime($notebcba->time_in2)),
                'tecnico' => [
                    'name' => $notebcba->tecnico->name,
                    'surname' => $notebcba->tecnico->surname,
                    'npi' => $notebcba->tecnico->npi,
                ],
                "supervisor_name" => $notebcba->supervisor_name,
                'supervisor' => $notebcba->supervisor,
                'supervisor' => [
                    'name' => $notebcba->supervisor->name,
                    'surname' => $notebcba->supervisor->surname,
                    'npi' => $notebcba->supervisor->npi,
                ],
                "aba_supervisor" => $notebcba->aba_supervisor,
                'abasupervisor' => $notebcba->abasupervisor,
                'abasupervisor' => [
                    'name' => $notebcba->abasupervisor->name,
                    'surname' => $notebcba->abasupervisor->surname,
                    'npi' => $notebcba->abasupervisor->npi,
                ],
                'cpt_code' => $notebcba->cpt_code,
                'mdbcba' => $notebcba->mdbcba,
                'md2bcba' => $notebcba->md2bcba,
                'billedbcba' => $notebcba->billedbcba,
                'paybcba' => $notebcba->paybcba,
                'meet_with_client_at' => $notebcba->meet_with_client_at,

                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,
                'status' => $notebcba->status,

                'created_at' => $notebcba->created_at,

                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,

            ];
        }


        return response()->json([
            'noteBcbas' => $notesBcbas,
            "noteRbts" => $notes,
            "patient" => $patient,
            "patient" => $patient->id ? [
                "patient_identifier" => $patient->patient_identifier,
                "full_name" => $patient->first_name . ' ' . $patient->last_name,
                "first_name" => $patient->first_name,
                "last_name" => $patient->last_name,
                "diagnosis_code" => $patient->diagnosis_code,
                "pos_covered" => $patient->pos_covered
                    ? json_decode($patient->pos_covered) : null,
                "insurer_id" => $patient->insurer_id,
                "rbt_home_id" => $patient->rbt_home_id,
                "rbt2_school_id" => $patient->rbt2_school_id,
                "bcba_home_id" => $patient->bcba_home_id,
                "bcba2_school_id" => $patient->bcba2_school_id,
            ] : null,



            "pos_covered" => is_string($patient->pos_covered)
                            ? json_decode($patient->pos_covered)
                            : $patient->pos_covered,


            "pa_services" => $patient->paServices,
            "totalPages" => $pages,
            "arrayPages" => $arrayPages
        ]);
    }



    // mostrar data por locacion

    public function showByLocationId(Request $request)
    {

        $size_pagination = 50;
        $name_doctor = $request->search;
        $session_date = $request->session_date;
        $location_id = $request->location_id;
        $id = $request->provider_id;
        $provider_id = $request->provider_id;
        $supervisor_name = $request->supervisor_name;

        $insurer_name = $request->search;

        $location = Location::where("id", $location_id)->first();


        $startDate = $request->date_start;
        $endDate = $request->date_end;

        $noteBcba = NoteBcba::where("location_id", $location_id);
        $noteRbt = NoteRbt::where("location_id", $location_id);
        if ($startDate && $endDate) {
            $noteBcba->whereBetween('session_date', [$startDate, $endDate]);
            $noteRbt->whereBetween('session_date', [$startDate, $endDate]);
        }

        $totalRbt = $noteRbt->count();
        $totalBcba = $noteBcba->count();

        if ($request->noteType === 'bcba') {
            $maxCant = $totalBcba;
        } elseif ($request->noteType === 'rbt') {
            $maxCant = $totalRbt;
        } else {
            $maxCant = $totalBcba > $totalRbt ? $totalBcba : $totalRbt;
        }

        $pages = floor($maxCant / $size_pagination);
        $remainder = $maxCant % $size_pagination;
        $pages = $remainder > 0 ? $pages + 1 : $pages;
        $arrayPages = [];
        for ($i = 1; $i <= $pages; $i++) {
            $arrayPages[] = $i;
        }

        if ($request->noteType === 'bcba' || !$request->noteType) {
            $noteBcba = $noteBcba->orderBy('session_date', 'desc')->paginate($size_pagination);
        }
        if ($request->noteType === 'rbt' || !$request->noteType) {
            $noteRbt = $noteRbt->orderBy('session_date', 'desc')->paginate($size_pagination);
        }

        $tecnicoRbts = NoteRbt::where("location_id", $location_id)
            ->with('doctor', 'desc')
            ->where('provider_id', $id)
            ->orderby('session_date', 'desc')
            ->get();

        $doctors = Patient::join('users', 'patients.id', '=', 'users.id')
            ->select(
                'patients.id as id',
                'users.name',
            )
            ->get();


        $doctor = NoteRbt::where("provider_id", $provider_id)->get();
        $tecnicoRbts = NoteRbt::where("provider_id", $provider_id)->get();
        $supervisor = NoteRbt::where("supervisor_name", $supervisor_name)->get();

        // if ($request->{'xe'}) {
        //     $request->request->add($xe);
        // }


        $notes = [];

        foreach ($noteRbt as $note) {
            /*Session 1*/
            $timeIn = Carbon::parse($note->time_in);
            $timeOut = Carbon::parse($note->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($note->time_in2);
            $timeOut2 = Carbon::parse($note->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15);

            /*Costo por unidad*/
            // $costoUnidad = 12.51;

            /*Pagar*/
            // $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo

            $notes[] = [
                'id' => $note->id,
                'patient_id' => $note->patient_id,


                'bip_id' => $note->bip_id,
                // 'supervisor_id' => $note->supervisor_id,
                'supervisor_name' => $note->supervisor_name,
                'supervisor' => [
                    'name' => $note->supervisor->name,
                    'surname' => $note->supervisor->surname,
                    'npi' => $note->supervisor->npi,
                ],
                'tecnicoRbt_id' => $note->provider_name,
                // 'tecnicoRbt_name' => $note->tecnicoRbt_name,
                'tecnicoRbt' => [
                    'name' => $note->tecnicoRbt->name,
                    'surname' => $note->tecnicoRbt->surname,
                    'npi' => $note->tecnicoRbt->npi,
                ],


                'pos' => $note->pos,
                'session_date' => $note->session_date,
                'meet_with_client_at' => $note->meet_with_client_at,
                'time_in' => $note->time_in,
                'time_out' => $note->time_out,
                'time_in2' => $note->time_in2,
                'time_out2' => $note->time_out2,
                "session_length_total" =>
                date("H:i", strtotime($note->time_out) - strtotime($note->time_in) + strtotime($note->time_out2) - strtotime($note->time_in2)),

                'cpt_code' => $note->cpt_code,
                'md' => $note->md,
                'md2' => $note->md2,

                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,
                'billed' => $note->billed,
                'pay' => $note->pay,
                'status' => $note->status,
                'created_at' => $note->created_at,

                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,

            ];
        }

        $notesBcbas = [];

        foreach ($noteBcba as $notebcba) {
            /*Session 1*/
            $timeIn = Carbon::parse($notebcba->time_in);
            $timeOut = Carbon::parse($notebcba->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($notebcba->time_in2);
            $timeOut2 = Carbon::parse($notebcba->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15);

            /*Costo por unidad*/
            $costoUnidad = 12.51;

            /*Pagar*/
            $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo


            $notesBcbas[] = [
                'id' => $notebcba->id,
                'patient_id' => $notebcba->patient_id,
                'bip_id' => $notebcba->bip_id,
                "cpt_code" => $notebcba->cpt_code,
                "provider_name" => $notebcba->provider_name,
                "session_date" => $notebcba->session_date,
                "session_length_total" =>
                date("H:i", strtotime($notebcba->time_out) - strtotime($notebcba->time_in) + strtotime($notebcba->time_out2) - strtotime($notebcba->time_in2)),
                'tecnico' => $notebcba->provider_name,
                'tecnico' => [
                    'name' => $notebcba->tecnico->name,
                    'surname' => $notebcba->tecnico->surname,
                    'npi' => $notebcba->tecnico->npi,
                ],
                "supervisor_name" => $notebcba->supervisor_name,
                'supervisor' => $notebcba->supervisor,
                'supervisor' => [
                    'name' => $notebcba->supervisor->name,
                    'surname' => $notebcba->supervisor->surname,
                    'npi' => $notebcba->supervisor->npi,
                ],
                "aba_supervisor" => $notebcba->aba_supervisor,
                'abasupervisor' => $notebcba->abasupervisor,
                'abasupervisor' => [
                    'name' => $notebcba->abasupervisor->name,
                    'surname' => $notebcba->abasupervisor->surname,
                    'npi' => $notebcba->abasupervisor->npi,
                ],
                'cpt_code' => $notebcba->cpt_code,
                'mdbcba' => $notebcba->mdbcba,
                'md2bcba' => $notebcba->md2bcba,
                'billedbcba' => $notebcba->billedbcba,
                'paybcba' => $notebcba->paybcba,
                'meet_with_client_at' => $notebcba->meet_with_client_at,

                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,
                'status' => $notebcba->status,

                'created_at' => $notebcba->created_at,

                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,

            ];
        }
        $patients = [];
        foreach ($patients as $patient) {
            // do something with $patient
        }


        return response()->json([
            "noteRbts" => $notes,
            'noteBcbas' => $notesBcbas,
            "location" => $location,
            "totalPages" => $pages,
            "arrayPages" => $arrayPages
        ]);
    }



    // mostrar data del paciente por doctor

    public function showByPatientByDoctorId(Request $request, $doctor_id, $patient_identfifier)
    {

        $size_pagination = 7;
        $patient_identifier = $request->patient_identifier;
        $doctor_id = $request->doctor_id;
        $startDate = $request->date_start;
        $endDate = $request->date_end;

        $doctor = User::where("id", $doctor_id)->first();

        $patient = Patient::where("patient_identifier", $patient_identifier)->first();


        $noteBcba = NoteBcba::where("provider_id", $doctor_id)
            ->where("patient_identifier", $patient_identifier);

        $noteRbt = NoteRbt::where("provider_id", $doctor_id)

            ->where("patient_identifier", $patient_identifier);





        if ($startDate && $endDate) {
            $noteBcba->whereBetween('session_date', [$startDate, $endDate]);
            $noteRbt->whereBetween('session_date', [$startDate, $endDate]);
        }

        $totalRbt = $noteRbt->count();
        $totalBcba = $noteBcba->count();

        if ($request->noteType === 'bcba') {
            $maxCant = $totalBcba;
        } elseif ($request->noteType === 'rbt') {
            $maxCant = $totalRbt;
        } else {
            $maxCant = $totalBcba > $totalRbt ? $totalBcba : $totalRbt;
        }

        $pages = floor($maxCant / $size_pagination);
        $remainder = $maxCant % $size_pagination;
        $pages = $remainder > 0 ? $pages + 1 : $pages;
        $arrayPages = [];
        for ($i = 1; $i <= $pages; $i++) {
            $arrayPages[] = $i;
        }

        if ($request->noteType === 'bcba' || !$request->noteType) {
            $noteBcba = $noteBcba->orderBy('session_date', 'desc')->paginate($size_pagination);
        }
        if ($request->noteType === 'rbt' || !$request->noteType) {
            $noteRbt = $noteRbt->orderBy('session_date', 'desc')->paginate($size_pagination);
        }


            $paService = $patient->paServices()->find(id: $patient->id);

        $notes = [];

        foreach ($noteRbt as $note) {
            /*Session 1*/
            $timeIn = Carbon::parse($note->time_in);
            $timeOut = Carbon::parse($note->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($note->time_in2);
            $timeOut2 = Carbon::parse($note->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15);

            /*Costo por unidad*/
            $costoUnidad = 12.51;

            /*Pagar*/
            $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo

            $notes[] = [
                'id' => $note->id,
                // 'Doctor id' => $note->doctor_id,
                'patient_id' => $note->patient_id,
                'bip_id' => $note->bip_id,
                'supervisor' => $note->supervisor_name,
                'supervisor' => $note->supervisor,
                'supervisor' => [
                    'name' => $note->supervisor->name,
                    'surname' => $note->supervisor->surname,
                    'npi' => $note->supervisor->npi,
                ],
                'tecnicoRbts' => $note->provider_id,
                'tecnicoRbt' => $note->tecnicoRbt,
                // 'tecnicoRbt' => [
                //     'name' => $note->tecnicoRbt->name,
                //     'surname' => $note->tecnicoRbt->surname,
                //     'npi' => $note->tecnicoRbt->npi,
                // ],


                'pos' => $note->pos,
                'session_date' => $note->session_date,
                'meet_with_client_at' => $note->meet_with_client_at,
                'time_in' => $note->time_in,
                'time_out' => $note->time_out,
                'time_in2' => $note->time_in2,
                'time_out2' => $note->time_out2,
                "total_hours" =>
                date("H:i", strtotime($note->time_out) - strtotime($note->time_in) + strtotime($note->time_out2) - strtotime($note->time_in2)),

                'cpt_code' => $note->cpt_code,
                'md' => $note->md,
                'md2' => $note->md2,

                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,
                'billed' => $note->billed,
                'pay' => $note->pay,
                'created_at' => $note->created_at,

                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,

            ];
        }

        $notesBcbas = [];

        foreach ($noteBcba as $notebcba) {
            /*Session 1*/
            $timeIn = Carbon::parse($notebcba->time_in);
            $timeOut = Carbon::parse($notebcba->time_out);

            $diferenciaMinutos = $timeOut->diffInMinutes($timeIn);

            $unidades1 = round($diferenciaMinutos / 15);

            /*Session 2*/
            $timeIn2 = Carbon::parse($notebcba->time_in2);
            $timeOut2 = Carbon::parse($notebcba->time_out2);

            $diferenciaMinutos2 = $timeOut2->diffInMinutes($timeIn2);

            $unidades2 = round($diferenciaMinutos2 / 15);

            /*Tontal de minutos*/
            $totalMinutosTotales2 = $diferenciaMinutos + $diferenciaMinutos2;

            /*Tontal de unidades*/
            $unidadesTotal = round($totalMinutosTotales2 / 15);

            /*Costo por unidad*/
            $costoUnidad = 12.51;

            /*Pagar*/
            $pagar = $unidadesTotal * $costoUnidad;

            $xe = $unidadesTotal * 0; // es excento por medicare, el seguro cubre todo


            $notesBcbas[] = [
                'id' => $notebcba->id,
                // 'Doctor id' => $note->doctor_id,
                'patient_id' => $notebcba->patient_id,
                'bip_id' => $notebcba->bip_id,
                "cpt_code" => $notebcba->cpt_code,
                "provider_name" => $notebcba->provider_name,
                "session_date" => $notebcba->session_date,
                'tecnico' => $notebcba->provider_id,
                // 'time_in' => $noteBcba->time_in,
                // 'time_out' => $noteBcba->time_out,
                // 'time_in2' => $noteBcba->time_in2,
                // 'time_out2' => $noteBcba->time_out2,
                "total_hours" =>
                date("H:i", strtotime($notebcba->time_out) - strtotime($notebcba->time_in) + strtotime($notebcba->time_out2) - strtotime($notebcba->time_in2)),
                // 'tecnico' => [
                //     'name' => $notebcba->tecnico->name,
                //     'surname' => $notebcba->tecnico->surname,
                //     'npi' => $notebcba->tecnico->npi,
                // ],
                "supervisor_name" => $notebcba->supervisor_id,
                'supervisor' => $notebcba->supervisor_id,
                'supervisor' => [
                    'name' => $notebcba->supervisor->name,
                    'surname' => $notebcba->supervisor->surname,
                    'npi' => $notebcba->supervisor->npi,
                ],
                "aba_supervisor" => $notebcba->aba_supervisor,
                'abasupervisor' => $notebcba->abasupervisor,
                // 'abasupervisor' => [
                //     'name' => $notebcba->abasupervisor->name,
                //     'surname' => $notebcba->abasupervisor->surname,
                //     'npi' => $notebcba->abasupervisor->npi,
                // ],
                'cpt_code' => $notebcba->cpt_code,
                'mdbcba' => $notebcba->mdbcba,
                'md2bcba' => $notebcba->md2bcba,
                'billedbcba' => $notebcba->billedbcba,
                'paybcba' => $notebcba->paybcba,
                'meet_with_client_at' => $notebcba->meet_with_client_at,

                'unidades_sesion_1' => $unidades1,
                'unidades_sesion_2' => $unidades2,
                'session_units_total' => $unidadesTotal,

                'created_at' => $notebcba->created_at,

                // 'Costo por unidad' => $costoUnidad,
                // 'Total a pagar' => $pagar,
                // 'Doctor' => $note->doctor,

            ];
        }

        $paService = PaService::where("patient_id", $patient->id)->get();

        return response()->json([
            "doctor_id" => $doctor_id,
            "doctor" => $doctor,
            "doctor" => $doctor->id ? [
                "doctor_id" => $doctor->id,
                "email" => $doctor->email,
                "full_name" => $doctor->name . ' ' . $doctor->surname,

            ] : null,

            "patient_identifier" => $patient_identifier,
            "patient" => $patient->patient_identifier ? [
                "patient_identifier" => $patient->patient_identifier,
                "full_name" => $patient->first_name . ' ' . $patient->last_name,
                "first_name" => $patient->first_name,
                "last_name" => $patient->last_name,
                "diagnosis_code" => $patient->diagnosis_code,
                "pa_services" => $paService,

                "pos_covered" => is_string($patient->pos_covered)
                            ? json_decode($patient->pos_covered)
                            : $patient->pos_covered,

                "insurance_identifier" => $patient->insurance_identifier,
                "insurer_id" => $patient->insurer_id,
                "rbt_home_id" => $patient->rbt_home_id,
                "rbt2_school_id" => $patient->rbt2_school_id,
                "bcba_home_id" => $patient->bcba_home_id,
                "bcba2_school_id" => $patient->bcba2_school_id,
            ] : null,


            'noteBcbas' => $notesBcbas,

            // date("H:i", strtotime($noteBcba->time_out) - strtotime($noteBcba->time_in) + strtotime($noteBcba->time_out2) - strtotime($noteBcba->time_in2)),


            "noteRbts" => $notes,
            "totalPages" => $pages,
            "arrayPages" => $arrayPages
        ]);
    }


    public function store(Request $request)
    {
        $patient = null;

        $patient = Patient::where("patient_identifier", $request->patient_identifier)->first();
        $doctor = User::where("id", $request->doctor_id)->first();


        $clientReport = ClientReport::create($request->all());

        return response()->json([
            "message" => 200,
            "clientReport" => $clientReport,
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
        $clientReport = ClientReport::findOrFail($id);
        // $patient = Patient::where("patient_id", $patient_id)->first();

        return response()->json([
            "clientReport" => BillingResource::make($clientReport),

        ]);
    }



    //traer el perfil con los datos del insurer aplicados en el registro
    public function showProfile($patient_identifier)
    {
        $patient = Patient::where("patient_identifier", $patient_identifier)->first();
        $noteRbt = NoteRbt::where("patient_id", $patient->id)->get();


        return response()->json([
            // "patient" => $patient,
            // "noteRbt" => $noteRbt,
            "full_name" => $patient->first_name . ' ' . $patient->last_name,
            "patient_identifier" => $patient->patient_identifier,
            "insurer_id" => $patient->insurer_id,
            "noteRbt" => NoteRbtCollection::make($noteRbt),
            "noteRbt" => $noteRbt->map(function ($noteRbt) {
                return [
                    "id" => $noteRbt->id,
                    "pos" => $noteRbt->pos,
                    "time_in" => $noteRbt->time_in,
                    "time_out" => $noteRbt->time_out,
                    "time_in2" => $noteRbt->time_in2,
                    "time_out2" => $noteRbt->time_out2,
                ];
            }),

            "pa_assessments" => $patient->pa_assessments
                ? json_decode($patient->pa_assessments) : null,

            // "bip" => BipResource::make($bip),
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
        //
    }

    public function updateTotals(Request $request, $id)
    {
        $clientReport = ClientReport::findOrfail($id);
        $clientReport->billing_total = $request->billing_total;
        $clientReport->week_total_hours = $request->week_total_hours;
        $clientReport->week_total_units = $request->week_total_units;
        $clientReport->cpt_code = $request->cpt_code;
        $clientReport->insurer_id = $request->insurer_id;
        $clientReport->insurer_rate = $request->insurer_rate;
        $clientReport->update();
        return $clientReport;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }







    //uniadades disponibles segun el cpt y el provider para el cliente
    public function showCptUnits(Request $request, string $patient_identifier, string $cpt_code, string $provider)
    {
        $patient = Patient::where("patient_identifier", $patient_identifier)->first();
        //obtenemos de la nota
        $noteRbts = NoteRbt::where("cpt_code", $cpt_code)
            ->where("patient_id", $patient->id)
            ->where("provider", $provider)
            ->get();


        $cpt = $cpt_code;
        $provider = $provider;



        $unitsCollection = collect();


        $result = $noteRbts->map(function ($noteRbt) {
            $totalHours = Carbon::parse($noteRbt->time_out2)->diffInSeconds(
                Carbon::parse($noteRbt->time_in2)
            ) / 3600
                + Carbon::parse($noteRbt->time_out)->diffInSeconds(
                    Carbon::parse($noteRbt->time_in)
                ) / 3600;
            $totalUnits = $totalHours * 4;

            return [
                "id" => $noteRbt->id,

                "total_hours" =>
                date("H:i", strtotime($noteRbt->time_out2) - strtotime($noteRbt->time_in2) + strtotime($noteRbt->time_out) - strtotime($noteRbt->time_in)),
                "total_units" => $totalUnits,
                "cpt_code" => $noteRbt->cpt_code,
                "provider" => $noteRbt->provider,
                "patient_id" => $noteRbt->patient_id,


            ];
        });

        //sumamos el total de las unidades de las notas rbt extraidas
        $totalSumUnits = $result->sum('total_units');

        return response()->json([

            "patient_identifier" => $patient->patient_identifier,
            "patient" => $patient_identifier ?
                [
                    "id" => $patient->id,
                    "email" => $patient->email,
                    "pa_assessments" => is_string($patient->pa_assessments)
                            ? json_decode($patient->pa_assessments)
                            : $patient->pa_assessments,

                ] : null,
            "notes" => $result,
            // "total_units_assigned" => $totalUnitsAssigned,
            "total_sum_units" => $totalSumUnits,

        ]);
    }
}
