<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bip\BipCollection;
use App\Http\Resources\Location\LocationCollection;
use App\Http\Resources\Appointment\AppointmentCollection;

class DashboardkpiController extends Controller
{
    public function config()
    {
        $users = User::orderBy("id", "desc")
        // ->whereHas("roles", function($q){
        //     $q->where("name","like","%DOCTOR%");
        // })
        ->get();

        return response()->json([
            "doctors" => $users->map(function ($user) {
                return[
                    "id" => $user->id,
                    "full_name" => $user->name . ' ' . $user->surname,
                ];
            })
        ]);
    }
    public function dashboard_admin(Request $request)
    {

        date_default_timezone_set('America/Caracas');
        //mes actual - bips
        $now = now();
        $num_bips_current = DB::table("bips")->where("deleted_at", null)
                            ->whereYear("created_at", $now->format("Y"))
                            ->whereMonth("created_at", $now->format("m"))
                            ->count();
        //mes anterior - bips
        $before = now()->subMonth();
        $num_bips_before = DB::table("bips")->where("deleted_at", null)
                            ->whereYear("created_at", $before->format("Y"))
                            ->whereMonth("created_at", $before->format("m"))
                            ->count();
        // versus % -appointmens
        $porcentajeD = 0;
        if ($num_bips_before > 0) {
            $porcentajeD = (($num_bips_current - $num_bips_before) / $num_bips_before) * 100;
        }


        //mes actual - patients
        $now = now();
        $num_patients_current = DB::table("patients")->where("deleted_at", null)
                            ->whereYear("created_at", $now->format("Y"))
                            ->whereMonth("created_at", $now->format("m"))
                            ->count();
        //mes anterior - patients
        $before = now()->subMonth();
        $num_patients_before = DB::table("patients")->where("deleted_at", null)
                            ->whereYear("created_at", $before->format("Y"))
                            ->whereMonth("created_at", $before->format("m"))
                            ->count();
        // versus % -patients
        $porcentajeDP = 0;
        if ($num_patients_before > 0) {
            $porcentajeDP = (($num_patients_current - $num_patients_before) / $num_patients_before) * 100;
        }


        //mes actual - bips-attentions
        $now = now();
        $num_bips_attention_current = DB::table("bips")->where("deleted_at", null)
                            ->whereYear("updated_at", $now->format("Y"))
                            ->whereMonth("updated_at", $now->format("m"))
                            ->count();
        //mes anterior - bips-attentions
        $before = now()->subMonth();
        $num_bips_attention_before = DB::table("bips")->where("deleted_at", null)
                            ->whereYear("updated_at", $before->format("Y"))
                            ->whereMonth("updated_at", $before->format("m"))
                            ->count();
        // versus % -appointmens-attentions
        $porcentajeDA = 0;
        if ($num_bips_attention_before > 0) {
            $porcentajeDA = (($num_bips_attention_current - $num_bips_attention_before) / $num_bips_attention_before) * 100;
        }

         $bips = Bip::get();
         $patients = Patient::get();
         $recent_patients = Patient::orderBy('created_at', 'DESC')->get();
         $noteRbts = NoteRbt::get();
         $noteBcbas = NoteBcba::get();
         $employees = User::get();
         $locations = Location::get();

        return response()->json([
            "bips" => BipCollection::make($bips),
            "locations" => LocationCollection::make($locations),
            "total_bips" => $bips->count(),
            "total_patients" => $patients->count(),
            "total_noteRbts" => $noteRbts->count(),
            "total_noteBcbas" => $noteBcbas->count(),
            "total_employees" => $employees->count(),
            "recent_patients" => $recent_patients,
            // "recent_patients"=>$recent_patients->count(),

            "num_bips_current" => $num_bips_current,
            "num_bips_before" => $num_bips_before,
            "porcentaje_d" => round($porcentajeD, 2),

            //
            "num_bips_attention_current" => $num_bips_attention_current,
            "num_bips_attention_before" => $num_bips_attention_before,
            "porcentaje_da" => round($porcentajeDA, 2),
             //
            "num_patients_current" => $num_patients_current,
            "num_patients_before" => $num_patients_before,
            "porcentajeDP" => round($porcentajeDP, 2),
             //
        ]);
    }

    public function dashboard_admin_year(Request $request)
    {
        $year = $request->year;
        $query_patients_by_gender = DB::table("bips")->where("bips.deleted_at", null)
                        ->whereYear("bips.created_at", $year)
                        ->join("patients", "bips.client_id", "=", "patients.id")
                        ->select(
                            DB::raw("YEAR(bips.created_at) as year"),
                            DB::raw("MONTH(bips.created_at) as month"),
                            DB::raw("SUM(CASE WHEN patients.gender = 1 THEN 1 ELSE 0 END) as hombre"),
                            DB::raw("SUM(CASE WHEN patients.gender = 2 THEN 1 ELSE 0 END) as mujer"),
                        )->groupBy("year", "month")
                        ->orderBy("year")
                        ->orderBy("month")
                        ->get();




        $months_name = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        return response()->json([
            "months_name" => $months_name,
            // "query_patients_speciality_porcentaje" => $query_patients_speciality_porcentaje,
            // "query_patients_speciality" => $query_patients_speciality,
            "query_patients_by_gender" => $query_patients_by_gender,
        ]);
    }

    public function dashboard_doctor(Request $request)
    {

        date_default_timezone_set('America/Caracas');

        $doctor_id = $request->doctor_id;

        //mes actual - bips
        $now = now();
        $num_bips_current = DB::table("bips")->where("deleted_at", null)
                            ->where("doctor_id", $doctor_id)
                            ->whereYear("created_at", $now->format("Y"))
                            ->whereMonth("created_at", $now->format("m"))
                            ->count();

        //mes anterior - appointments
        $before = now()->subMonth();
        $num_bips_before = DB::table("bips")->where("deleted_at", null)
                            ->where("doctor_id", $doctor_id)
                            ->whereYear("created_at", $before->format("Y"))
                            ->whereMonth("created_at", $before->format("m"))
                            ->count();
        // versus % -appointmens
        $porcentajeD = 0;
        if ($num_bips_before > 0) {
            $porcentajeD = (($num_bips_current - $num_bips_before) / $num_bips_before) * 100;
        }



        //mes actual - bips-attentions
        $now = now();
        $num_bips_attention_current = DB::table("bips")->where("deleted_at", null)
                            ->where("doctor_id", $doctor_id)
                            ->whereYear("updated_at", $now->format("Y"))
                            ->whereMonth("updated_at", $now->format("m"))
                            ->count();
        //mes anterior - bips-attentions
        $before = now()->subMonth();
        $num_bips_attention_before = DB::table("bips")->where("deleted_at", null)
                            ->where("doctor_id", $doctor_id)
                            ->whereYear("updated_at", $before->format("Y"))
                            ->whereMonth("updated_at", $before->format("m"))
                            ->count();
        // versus % -appointmens-attentions
        $porcentajeDA = 0;
        if ($num_bips_attention_before > 0) {
            $porcentajeDA = (($num_bips_attention_current - $num_bips_attention_before) / $num_bips_attention_before) * 100;
        }



        $bips = Bip::where('doctor_id', $doctor_id)->get();

        return response()->json([
            // "bips"=>BipCollection::make($bips),
            "total_bips" => $bips->count(),
            "num_bips_current" => $num_bips_current,
            "num_bips_before" => $num_bips_before,
            "porcentaje_d" => round($porcentajeD, 2),
            //
            "num_bips_attention_current" => $num_bips_attention_current,
            "num_bips_attention_before" => $num_bips_attention_before,
            "porcentaje_da" => round($porcentajeDA, 2),
             //
            // "num_bips_total_pay_current"=>$num_bips_total_pay_current,
            // "num_bips_total_pay_before"=>$num_bips_total_pay_before,
            // "porcentaje_dtp"=> round($porcentajeDTP,2),
            //
            // "num_bips_total_pending_current"=>$num_bips_total_pending_current,
            // "num_bips_total_pending_before"=>$num_bips_total_pending_before,
            // "porcentaje_dtpn"=> round($porcentajeDTPN,2),
        ]);
    }

    public function dashboard_doctor_year(Request $request)
    {

        $year = $request->year;
        $doctor_id = $request->doctor_id;

        $query_patients_by_gender = DB::table("bips")->where("bips.deleted_at", null)
                        ->whereYear("bips.created_at", $year)
                        ->where("bips.doctor_id", $doctor_id)
                        ->join("patients", "bips.client_id", "=", "patients.id")
                        ->select(
                            DB::raw("YEAR(bips.created_at) as year"),
                            DB::raw("SUM(CASE WHEN patients.gender = 1 THEN 1 ELSE 0 END) as hombre"),
                            DB::raw("SUM(CASE WHEN patients.gender = 2 THEN 1 ELSE 0 END) as mujer"),
                        )->groupBy("year")
                        ->orderBy("year")
                        ->get();


        //ingresos generales del año
        // $query_income_year = DB::table("appointments")->where("appointments.deleted_at",NULL)
        //                 ->whereYear("bips.created_at", $year)
        //                 ->where("bips.doctor_id", $doctor_id)
        //                 // ->where("bips.status_pay", 1)
        //                 ->select(
        //                     DB::raw("YEAR(bips.date_appointment) as year"),
        //                     DB::raw("MONTH(bips.date_appointment) as month"),
        //                     // DB::raw("SUM(bips.amount) as income ")
        //                 )->groupBy("year", "month")
        //                 ->orderBy("year")
        //                 ->orderBy("month")
        //                 ->get();

        // $query_n_appointment_year = DB::table("appointments")->where("appointments.deleted_at",NULL)
        //                         ->whereYear("appointments.date_appointment", $year)
        //                         ->where("appointments.doctor_id", $doctor_id)
        //                         ->select(
        //                             DB::raw("YEAR(appointments.date_appointment) as year"),
        //                             DB::raw("MONTH(appointments.date_appointment) as month"),
        //                             DB::raw("COUNT(*) as count_appointments")
        //                         )->groupBy("year", "month")
        //                         ->orderBy("year")
        //                         ->orderBy("month")
        //                         ->get();

        // $query_n_appointment_year_before = DB::table("appointments")->where("appointments.deleted_at",NULL)
        //                         ->whereYear("appointments.date_appointment", $year - 1)
        //                         ->where("appointments.doctor_id", $doctor_id)
        //                         ->select(
        //                             DB::raw("YEAR(appointments.date_appointment) as year"),
        //                             DB::raw("MONTH(appointments.date_appointment) as month"),
        //                             DB::raw("COUNT(*) as count_appointments")
        //                         )->groupBy("year", "month")
        //                         ->orderBy("year")
        //                         ->orderBy("month")
        //                         ->get();

        // $join_n_appointments_years = collect([]);

        $months_name = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        // foreach($query_n_appointment_year->merge($query_n_appointment_year_before)->groupBy("month") as $key => $month_year){
        //     $join_n_appointments_years->push([
        //         "month"=>$key,
        //         "months_name"=>$months_name[$key - 1],
        //         "details"=>$month_year
        //     ]);
        // }

        return response()->json([
            "months_name" => $months_name,
            // "join_n_appointments_years" => $join_n_appointments_years,
            // "query_n_appointment_year" => $query_n_appointment_year,
            // "query_n_appointment_year_before" => $query_n_appointment_year_before,
            // "query_income_year" => $query_income_year,
            "query_patients_by_gender" => $query_patients_by_gender,
        ]);
    }

    public function dashboard_patient(Request $request)
    {

        date_default_timezone_set('America/Caracas');

        $client_id = $request->client_id;

        //mes actual - appointments
        $now = now();
        $num_appointments_current = DB::table("bips")->where("deleted_at", null)
                            ->where("client_id", $client_id)
                            ->whereYear("created_at", $now->format("Y"))
                            ->whereMonth("created_at", $now->format("m"))
                            ->count();

        //mes anterior - appointments
        $before = now()->subMonth();
        $num_appointments_before = DB::table("bips")->where("deleted_at", null)
                            ->where("client_id", $client_id)
                            ->whereYear("created_at", $before->format("Y"))
                            ->whereMonth("created_at", $before->format("m"))
                            ->count();
        // versus % -appointmens
        $porcentajeD = 0;
        if ($num_appointments_before > 0) {
            $porcentajeD = (($num_appointments_current - $num_appointments_before) / $num_appointments_before) * 100;
        }



        //mes actual - appointments-attentions
        $now = now();
        $num_appointments_attention_current = DB::table("bips")->where("deleted_at", null)
                            ->where("client_id", $client_id)
                            ->whereYear("created_at", $now->format("Y"))
                            ->whereMonth("created_at", $now->format("m"))
                            ->count();
        //mes anterior - appointments-attentions
        $before = now()->subMonth();
        $num_appointments_attention_before = DB::table("bips")->where("deleted_at", null)
                            ->where("client_id", $client_id)
                            ->whereYear("created_at", $before->format("Y"))
                            ->whereMonth("created_at", $before->format("m"))
                            ->count();
        // versus % -appointmens-attentions
        $porcentajeDA = 0;
        if ($num_appointments_attention_before > 0) {
            $porcentajeDA = (($num_appointments_attention_current - $num_appointments_attention_before) / $num_appointments_attention_before) * 100;
        }

         //mes actual -  appointement pago total $ - (ganancias)
        //  $now = now();
        //  $num_appointments_total_pay_current = DB::table("bips")->where("deleted_at", NUll)
        //                     ->where("client_id", $client_id)
        //                      ->whereYear("created_at",$now->format("Y"))
        //                      ->whereMonth("created_at",$now->format("m"))
        //                      ->where("status_pay",1)
        //                      ->sum("bips.amount");
        //  //mes anterior -  appointement pago total $ - (ganancias)
        //  $before = now()->subMonth();
        //  $num_appointments_total_pay_before = DB::table("bips")->where("deleted_at", NUll)
        //                     ->where("client_id", $client_id)
        //                      ->whereYear("created_at",$before->format("Y"))
        //                      ->whereMonth("created_at",$before->format("m"))
        //                      ->where("status_pay",1)
        //                      ->sum("bips.amount");
        //  // versus % - appointement total $ - (ganancias)
        //  $porcentajeDTP = 0;
        //  if($num_appointments_total_pay_before > 0){
        //      $porcentajeDTP = (($num_appointments_total_pay_current - $num_appointments_total_pay_before) / $num_appointments_total_pay_before)* 100;
        //  }

        //  //mes actual -  appointement pago pendiente $ - (ganancias)
        //  $now = now();
        //  $num_appointments_total_pending_current = DB::table("bips")->where("deleted_at", NUll)
        //                     ->where("client_id", $client_id)
        //                      ->whereYear("created_at",$now->format("Y"))
        //                      ->whereMonth("created_at",$now->format("m"))
        //                      ->where("status_pay",2)
        //                      ->sum("bips.amount");
        //  //mes anterior -  appointement pago pendiente $ - (ganancias)
        //  $before = now()->subMonth();
        //  $num_appointments_total_pending_before = DB::table("bips")->where("deleted_at", NUll)
        //                     ->where("client_id", $client_id)
        //                      ->whereYear("created_at",$before->format("Y"))
        //                      ->whereMonth("created_at",$before->format("m"))
        //                      ->where("status_pay",2)
        //                      ->sum("bips.amount");
        //  // versus % - appointement total $ - (ganancias)
        //  $porcentajeDTPN = 0;
        //  if($num_appointments_total_pending_before > 0){
        //      $porcentajeDTPN = (($num_appointments_total_pending_current - $num_appointments_total_pending_before) / $num_appointments_total_pending_before)* 100;
        //  }
        //  whereYear("date_appointment", $now->format("Y"))
         $bips = Bip::where("client_id", $client_id)
                                    // ->whereMonth("date_appointment", $now->format("m"))
                                    // ->where("status",'active')
                                    ->take(5)
                                    ->orderBy("id", "desc")
                                    ->get();

        return response()->json([
            "bips" => BipCollection::make($bips),
            "num_appointments_current" => $num_appointments_current,
            "num_appointments_before" => $num_appointments_before,
            "porcentaje_d" => round($porcentajeD, 2),
            //
            "num_appointments_attention_current" => $num_appointments_attention_current,
            "num_appointments_attention_before" => $num_appointments_attention_before,
            "porcentaje_da" => round($porcentajeDA, 2),
             //
            // "num_appointments_total_pay_current"=>$num_appointments_total_pay_current,
            // "num_appointments_total_pay_before"=>$num_appointments_total_pay_before,
            // "porcentaje_dtp"=> round($porcentajeDTP,2),
            // //
            // "num_appointments_total_pending_current"=>$num_appointments_total_pending_current,
            // "num_appointments_total_pending_before"=>$num_appointments_total_pending_before,
            // "porcentaje_dtpn"=> round($porcentajeDTPN,2),
        ]);
    }

    public function dashboard_patient_year(Request $request)
    {

        $year = $request->year;
        $client_id = $request->client_id;

        $query_patients_by_gender = DB::table("bips")->where("bips.deleted_at", null)
                        ->whereYear("bips.created_at", $year)
                        ->where("bips.client_id", $client_id)
                        ->join("patients", "bips.client_id", "=", "patients.id")
                        ->select(
                            DB::raw("YEAR(bips.created_at) as year"),
                            DB::raw("SUM(CASE WHEN patients.gender = 1 THEN 1 ELSE 0 END) as hombre"),
                            DB::raw("SUM(CASE WHEN patients.gender = 2 THEN 1 ELSE 0 END) as mujer"),
                        )->groupBy("year")
                        ->orderBy("year")
                        ->get();


        //ingresos generales del año
        // $query_income_year = DB::table("bips")->where("bips.deleted_at",NULL)
        //                 ->whereYear("bips.created_at", $year)
        //                 ->where("bips.client_id", $client_id)
        //                 ->where("bips.status_pay", 1)
        //                 ->select(
        //                     DB::raw("YEAR(bips.created_at) as year"),
        //                     DB::raw("MONTH(bips.created_at) as month"),
        //                     DB::raw("SUM(bips.amount) as income ")
        //                 )->groupBy("year", "month")
        //                 ->orderBy("year")
        //                 ->orderBy("month")
        //                 ->get();

        // $query_n_appointment_year = DB::table("bips")->where("bips.deleted_at",NULL)
        //                         ->whereYear("bips.created_at", $year)
        //                         ->where("bips.client_id", $client_id)
        //                         ->select(
        //                             DB::raw("YEAR(bips.created_at) as year"),
        //                             DB::raw("MONTH(bips.created_at) as month"),
        //                             DB::raw("COUNT(*) as count_appointments")
        //                         )->groupBy("year", "month")
        //                         ->orderBy("year")
        //                         ->orderBy("month")
        //                         ->get();

        // $query_n_appointment_year_before = DB::table("bips")->where("bips.deleted_at",NULL)
        //                         ->whereYear("bips.date_appointment", $year - 1)
        //                         ->where("bips.client_id", $client_id)
        //                         ->select(
        //                             DB::raw("YEAR(bips.date_appointment) as year"),
        //                             DB::raw("MONTH(bips.date_appointment) as month"),
        //                             DB::raw("COUNT(*) as count_appointments")
        //                         )->groupBy("year", "month")
        //                         ->orderBy("year")
        //                         ->orderBy("month")
        //                         ->get();

        // $join_n_appointments_years = collect([]);

        // $months_name = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        // foreach($query_n_appointment_year->merge($query_n_appointment_year_before)->groupBy("month") as $key => $month_year){
        //     $join_n_appointments_years->push([
        //         "month"=>$key,
        //         "months_name"=>$months_name[$key - 1],
        //         "details"=>$month_year
        //     ]);
        // }

        $noteRbts = NoteRbt::where('client_id', $client_id)->get();
         $noteBcbas = NoteBcba::where('client_id', $client_id)->get();

        return response()->json([
            "noteRbts" => $noteRbts,
            "noteBcbas" => $noteBcbas,
            // "join_n_appointments_years" => $join_n_appointments_years,
            // "query_n_appointment_year" => $query_n_appointment_year,
            // "query_n_appointment_year_before" => $query_n_appointment_year_before,
            // "query_income_year" => $query_income_year,
            "query_patients_by_gender" => $query_patients_by_gender,
        ]);
    }


    public function configPatients()
    {
        $patients = Patient::orderBy("id", "desc")->get();

        return response()->json([
            "patients" => $patients->map(function ($patients) {
                return[
                    "id" => $patients->id,
                    "full_name" => $patients->first_name . ' ' . $patients->last_name,
                ];
            })
        ]);
    }
}
