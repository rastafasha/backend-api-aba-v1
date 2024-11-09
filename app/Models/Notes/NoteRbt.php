<?php

namespace App\Models\Notes;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Location;
use App\Models\Patient\Patient;
use App\Models\Notes\Maladaptive;
use App\Models\Notes\Replacement;
use App\Models\PaService;
use App\Utils\TimeCalculator;
use App\Utils\UnitCalculator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="NoteRbt",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="doctor_id", type="integer", nullable=true),
 *     @OA\Property(property="patient_id", type="string", nullable=true),
 *     @OA\Property(property="bip_id", type="integer", nullable=true),
 *     @OA\Property(property="provider_name_g", type="integer", nullable=true),
 *     @OA\Property(property="provider_credential", type="string", nullable=true),
 *     @OA\Property(property="pos", type="string", nullable=true),
 *     @OA\Property(property="session_date", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="time_in", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_out", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_in2", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_out2", type="string", format="time", nullable=true),
 *     @OA\Property(property="environmental_changes", type="string", nullable=true),
 *     @OA\Property(property="maladaptives", type="object", nullable=true),
 *     @OA\Property(property="replacements", type="object", nullable=true),
 *     @OA\Property(property="interventions", type="object", nullable=true),
 *     @OA\Property(property="meet_with_client_at", type="string", nullable=true),
 *     @OA\Property(property="client_appeared", type="string", nullable=true),
 *     @OA\Property(property="as_evidenced_by", type="string", nullable=true),
 *     @OA\Property(property="rbt_modeled_and_demonstrated_to_caregiver", type="string", nullable=true),
 *     @OA\Property(property="client_response_to_treatment_this_session", type="string", nullable=true),
 *     @OA\Property(property="progress_noted_this_session_compared_to_previous_session", type="string", nullable=true),
 *     @OA\Property(property="next_session_is_scheduled_for", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="provider_signature", type="string", nullable=true),
 *     @OA\Property(property="provider_name", type="integer", nullable=true),
 *     @OA\Property(property="supervisor_signature", type="string", nullable=true),
 *     @OA\Property(property="supervisor_name", type="integer", nullable=true),
 *     @OA\Property(property="billed", type="boolean", default=false),
 *     @OA\Property(property="pay", type="boolean", default=false),
 *     @OA\Property(property="status", type="string", enum={"pending", "ok", "no", "review"}, default="pending"),
 *     @OA\Property(property="cpt_code", type="string", nullable=true),
 *     @OA\Property(property="location_id", type="integer", nullable=true),
 *     @OA\Property(property="md", type="string", maxLength=20, nullable=true),
 *     @OA\Property(property="md2", type="string", maxLength=20, nullable=true),
 *     @OA\Property(property="provider", type="integer", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 */
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
        'session_length_total',
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

    protected $casts = [
        'maladaptives' => 'json',
        'replacements' => 'json',
        'interventions' => 'json',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function paService()
    {
        return $this->belongsTo(PaService::class, 'pa_service_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class,);
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

    // public function maladaptive()
    // {
    //     return $this->hasMany(Maladaptive::class);
    // }
    // public function replacement()
    // {
    //     return $this->hasMany(Replacement::class);
    // }

    protected function getTotalMinutesAttribute()
    {
        $calculator = new TimeCalculator();
        $totalMinutes = 0;
        
        if ($this->time_in && $this->time_out) {
            $totalMinutes = $calculator->timeDifference($this->time_in, $this->time_out, "minutes");
        }
        
        if ($this->time_in2 && $this->time_out2) {
            $totalMinutes += $calculator->timeDifference($this->time_in2, $this->time_out2, "minutes");
        }
        
        return $totalMinutes;
    }

    protected function getTotalUnitsAttribute()
    {
        if ($this->total_minutes === null) {
            return null;
        }

        $calculator = new UnitCalculator();
        return $calculator->calculateUnits($this->total_minutes);
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
