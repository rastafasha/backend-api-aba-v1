<?php

namespace App\Models\Notes;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Location;
use App\Models\Patient\Patient;
use App\Models\Notes\Maladaptive;
use App\Models\Notes\Replacement;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoteRbt extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'bip_id',
        'provider_credential',
        'pos',
        'session_date',
        'time_in',
        'time_out',
        'time_in2',
        'time_out2',
        'environmental_changes',
        'maladaptives',
        'replacements',
        'interventions',
        'meet_with_client_at',
        'client_appeared',
        'as_evidenced_by',
        'rbt_modeled_and_demonstrated_to_caregiver',
        'client_response_to_treatment_this_session',
        'progress_noted_this_session_compared_to_previous_session',
        'next_session_is_scheduled_for',
        'provider_name_g',
        'provider_signature',
        'provider_name',
        'supervisor_signature',
        'supervisor_name',
        'billed',
        'pay',
        'md',
        'md2',
        'cpt_code',
        'provider',
        'status',
        'location_id',
        'pa_service_id',
        'insuranceId',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function paService()
    {
        return $this->belongsTo(PaService::class, 'pa_service_id');
    }

    public function doctor()
    {
        return $this->hasMany(User::class,);
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_name');
    }
    public function tecnicoRbt()
    {
        return $this->belongsTo(User::class, 'provider_name_g');
    }

    public function bips()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public function maladaptive()
    {
        return $this->hasMany(Maladaptive::class);
    }
    public function replacement()
    {
        return $this->hasMany(Replacement::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }


    // public function scopefilterAdvanceClientReport(
    //     $query,
    //     $provider_name_g,
    //     $session_date,
    //     $patient_id,
    //     $doctor_id
    //     ){


    //     if($provider_name_g){
    //         $query->whereHas("doctor", function($q)use($provider_name_g){
    //             $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"),"like","%".$provider_name_g."%");

    //         });
    //     }

    //     if($provider_name_g){
    //         $query->where("provider_name_g", $provider_name_g);
    //     }


    //     if($patient_id){
    //         $query->where("patient_id", $patient_id);
    //     }

    //     if($session_date ){
    //         $query->where("noterbts", [
    //             Carbon::parse($session_date)->format("Y-m-d"),
    //         ]);
    //     }
    //     return $query;
    // }


    public function scopefilterAdvanceClientReport(
        $query,
        // $speciality_id,
        $search_doctor,
        $search_tecnicoRbt,
        $search_supervisor,
        // $search_patient,
        $date_start,
        $date_end
    ) {

        // if($speciality_id){
        //     $query->where("speciality_id", $speciality_id);
        // }

        if ($search_doctor) {
            $query->whereHas("doctor", function ($q) use ($search_doctor) {
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"), "like", "%" . $search_doctor . "%");
            });
        }
        if ($search_tecnicoRbt) {
            $query->whereHas("doctor", function ($q) use ($search_tecnicoRbt) {
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"), "like", "%" . $search_tecnicoRbt . "%");
            });
        }
        if ($search_supervisor) {
            $query->whereHas("doctor", function ($q) use ($search_supervisor) {
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"), "like", "%" . $search_supervisor . "%");
            });
        }
        // if($search_patient){
        //     $query->whereHas("patient", function($q)use($search_patient){
        //         $q->where(DB::raw("CONCAT(patients.name,' ',IFNULL(patients.surname,''),' ',IFNULL(patients.email,''))"),"like","%".$search_patient."%");

        //     });
        // }

        if ($date_start && $date_end) {
            $query->whereBetween("session_date", [
                Carbon::parse($date_start)->format("Y-m-d"),
                Carbon::parse($date_end)->format("Y-m-d"),
            ]);
        }
        return $query;
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider')->withDefault();
    }
}
