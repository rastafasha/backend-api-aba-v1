<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralizationTraining extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'patient_identifier',
        'client_id',
        'discharge_plan',
        'transition_fading_plans',//json
    ];

    protected $casts = [
        'transition_fading_plans' => 'array',
    ];

    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'client_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
