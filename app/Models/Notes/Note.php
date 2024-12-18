<?php

namespace App\Models\Notes;

use App\Models\Bip\Bip;
use App\Models\Location;
use App\Models\PaService;
use App\Models\Patient\Patient;
use App\Models\User;
use App\Traits\SessionDateFilterable;
use App\Utils\TimeCalculator;
use App\Utils\UnitCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Insurance\Insurance;
abstract class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use HasProvider;
    // use HasSupervisor;
    // use HasDoctor;
    use SessionDateFilterable;

    protected $fillable = [
        'insurance_id',
        'patient_id',
        'patient_identifier',
        'time_in',
        'time_out',
        'time_in2',
        'time_out2',
        'provider_id',
        'location_id',
        'session_date',
        'cpt_code',
        'status',
        'billed',
        'paid',
        'md',
        'md2',
        'md3',
        'doctor_id',
        'bip_id',
        'summary_note',
        'pa_service_id',
        'insurance_identifier',
    ];

    protected $appends = ['total_units', 'total_minutes'];

    protected static $userFields = ['id', 'name', 'surname', 'npi', 'electronic_signature'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_identifier', 'patient_identifier');
    }

    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public function paService()
    {
        return $this->belongsTo(PaService::class, 'pa_service_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id')->select(self::$userFields);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id')->select(self::$userFields);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id')->select(self::$userFields);
    }

    public function getPosStringAttribute()
    {
        switch ($this->meet_with_client_at) {
            case '03':
                return 'School';
            case '12':
                return 'Home';
            case '02':
                return 'Telehealth';
            case '99':
                return 'Other';
            default:
                return 'Unknown';
        }
    }

    public function getPatientIdentifierAttribute()
    {
        // return Patient::where('id', $this->patient_id)->value('patient_id');
        return Patient::where('id', $this->patient_id)->value('patient_identifier');
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
