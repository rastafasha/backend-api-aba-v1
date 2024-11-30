<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeEscalationTechnique extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'patient_identifier',
        'client_id',
        'description',
        'service_recomendation',
        'recomendation_lists',//json


    ];

    // protected $casts = [
    //     'recomendation_lists' => 'array',
    // ];

    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_identifier');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
