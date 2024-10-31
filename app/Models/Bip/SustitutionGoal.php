<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SustitutionGoal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        'bip_id',
        'patient_id',
        'client_id',
        'current_status',
        'goal',
        'description',
        'goalstos',//json
        'goalltos',//json

    ];

    // protected $casts = [
    //     'goalstos' => 'array',
    //     'goalltos' => 'array',
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

    // public function goalstos()
    // {
    //     return $this->hasMany(Goalsto::class);
    // }


}
