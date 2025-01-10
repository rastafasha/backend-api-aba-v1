<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use App\Models\User;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReductionGoal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'patient_identifier',
        'client_id',
        'current_status',
        'maladaptive',
        'baseline',
        'goalstos', //json
        'goalltos', //json
    ];

    public function bip()
    {
        return $this->belongsTo(Bip::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_identifier', 'patient_identifier');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
