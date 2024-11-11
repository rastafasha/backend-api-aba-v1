<?php

namespace App\Models\Bip;

use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrisisPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'patient_id',
        'client_id',
        'crisis_description',
        'crisis_note',
        'caregiver_requirements_for_prevention_of_crisis',
        'risk_factors', //json
        'suicidalities', //json
        'homicidalities', //json
    ];

    // protected $casts = [
    //     'risk_factors' => 'array',
    //     'suicidalities' => 'array',
    //     'homicidalities' => 'array',
    // ];

    // Updated relationships to match database structure
    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
