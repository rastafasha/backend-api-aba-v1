<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BehaviorAsistant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        'bip_id',
        'patient_id',
        'client_id',
        'behavior_assistant_work_schedule',//json

    ];

    // protected $casts = [
    //     'behavior_assistant_work_schedule' => 'array',
    // ];

    public function bips()
    {
        return $this->hasMany(Bip::class, 'bip_id');
    }
    public function patient()
    {
        return $this->hasMany(Patient::class,'patient_id');
    }
}
