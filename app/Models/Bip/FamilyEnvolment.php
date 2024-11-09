<?php

namespace App\Models\Bip;

use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyEnvolment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'patient_id',
        'client_id',
        'caregivers_training_goals', //json
    ];

    // protected $casts = [
    //     'caregivers_training_goals' => 'array',
    // ];

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
