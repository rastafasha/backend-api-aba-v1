<?php

namespace App\Models\Notes;

use App\Models\Location;
use App\Models\Notes\Traits\HasClientFromBip;
use App\Models\Notes\Traits\HasDoctor;
use App\Models\Notes\Traits\HasProvider;
use App\Models\Notes\Traits\HasSupervisor;
use App\Models\PaService;
use App\Models\Patient\Patient;
use App\Utils\TimeCalculator;
use App\Utils\UnitCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasProvider;
    use HasSupervisor;
    use HasClientFromBip;
    use HasDoctor;

    protected $fillable = [
        'insurance_id',
        'patient_id',
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
        'pay',
    ];

    protected $appends = ['provider', 'supervisor', 'doctor', 'total_units', 'total_minutes', 'client_id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function paService()
    {
        return $this->belongsTo(PaService::class, 'pa_service_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
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
