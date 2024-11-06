<?php

namespace App\Models\Notes;

use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Location;
use App\Models\PaService;
use App\Models\Patient\Patient;
use App\Utils\TimeCalculator;
use App\Utils\UnitCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="NoteBcba",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="bip_id", type="integer", nullable=true),
 *     @OA\Property(property="patient_id", type="integer"),
 *     @OA\Property(property="doctor_id", type="integer", nullable=true),
 *     @OA\Property(property="note_description", type="string", nullable=true),
 *     @OA\Property(property="caregiver_goals", type="object", nullable=true),
 *     @OA\Property(property="rbt_training_goals", type="object", nullable=true),
 *     @OA\Property(property="location", type="string", nullable=true),
 *     @OA\Property(property="summary_note", type="string", nullable=true),
 *     @OA\Property(property="birth_date", type="string", format="date", nullable=true),
 *     @OA\Property(property="aba_supervisor", type="integer", nullable=true),
 *     @OA\Property(property="cpt_code", type="string", nullable=true),
 *     @OA\Property(property="diagnosis_code", type="string", nullable=true),
 *     @OA\Property(property="rendering_provider", type="integer", nullable=true),
 *     @OA\Property(
 *         property="rendering",
 *         type="object",
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="surname", type="string"),
 *         @OA\Property(property="npi", type="string")
 *     ),
 *     @OA\Property(property="provider_signature", type="string", nullable=true),
 *     @OA\Property(property="provider_name", type="integer", nullable=true),
 *     @OA\Property(
 *         property="tecnico",
 *         type="object",
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="surname", type="string"),
 *         @OA\Property(property="npi", type="string")
 *     ),
 *     @OA\Property(property="supervisor_signature", type="string", nullable=true),
 *     @OA\Property(property="supervisor_name", type="integer", nullable=true),
 *     @OA\Property(
 *         property="supervisor",
 *         type="object",
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="surname", type="string"),
 *         @OA\Property(property="npi", type="string")
 *     ),
 *     @OA\Property(property="billedbcba", type="boolean", nullable=true),
 *     @OA\Property(property="paybcba", type="boolean", nullable=true),
 *     @OA\Property(property="bcba", type="string", nullable=true),
 *     @OA\Property(property="mdbcba", type="string", nullable=true),
 *     @OA\Property(property="md2bcba", type="string", nullable=true),
 *     @OA\Property(property="meet_with_client_at", type="string", nullable=true),
 *     @OA\Property(property="provider", type="integer", nullable=true),
 *     @OA\Property(property="status", type="string", nullable=true),
 *     @OA\Property(property="location_id", type="integer", nullable=true),
 *     @OA\Property(property="session_date", type="string", format="date", nullable=true),
 *     @OA\Property(property="time_in", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_out", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_in2", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_out2", type="string", format="time", nullable=true),
 *     @OA\Property(property="session_length_total", type="string", format="time", nullable=true),
 *     @OA\Property(property="session_length_total2", type="string", format="time", nullable=true),
 *     @OA\Property(property="total_hours", type="string", format="time", nullable=true),
 *     @OA\Property(property="total_minutes", type="integer", nullable=true),
 *     @OA\Property(property="total_units", type="integer", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class NoteBcba extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'bip_id',
        'location',
        'rendering_provider',

        'maladaptives',//json
        'replacements',//json

        'summary_note',

        'diagnosis_code',
        'birth_date',
        'aba_supervisor',
        // 'note_description',


        'caregiver_goals', //json
        'rbt_training_goals', //json

        'provider_signature',
        'provider_name',
        'supervisor_signature',
        'supervisor_name',

        'session_date',
        'time_in',
        'time_out',
        'time_in2',
        'time_out2',
        'session_length_total',
        'session_length_total2',
        'environmental_changes',

        'meet_with_client_at',
        'billedbcba',
        'paybcba',
        'mdbcba',
        'md2bcba',
        'cpt_code',
        'provider',
        'status',
        'location_id',
        'pa_service_id',
        'insuranceId',
    ];

    // protected $casts = [
    //     'maladaptives' => 'json',
    //     'replacements' => 'json',
    // ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function paService()
    {
        return $this->belongsTo(PaService::class, 'pa_service_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, "supervisor_name");
    }

    public function abasupervisor()
    {
        return $this->belongsTo(User::class, 'aba_supervisor');
    }
    public function rendering()
    {
        return $this->belongsTo(User::class, 'rendering_provider');
    }
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'provider_name');
    }

    public function bips()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class,'location_id');
    }

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
}
