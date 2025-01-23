<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class CrisisPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'crisis_description',
        'crisis_note',
        'caregiver_requirements_for_prevention_of_crisis',
        'risk_factors', //json
        'suicidalities', //json
        'homicidalities', //json
    ];

    protected $casts = [
        'risk_factors' => 'array',
        'suicidalities' => 'array',
        'homicidalities' => 'array',
    ];

    // Updated relationships to match database structure
    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }


    // validation rules
    public static function validate($data)
    {
        $rules = [
            'bip_id' => 'required|exists:bips,id',
            'crisis_description' => 'nullable|string',
            'crisis_note' => 'nullable|string',
            'caregiver_requirements_for_prevention_of_crisis' => 'nullable|string',
            'risk_factors' => 'nullable|array',
            'suicidalities' => 'nullable|array',
            'homicidalities' => 'nullable|array'
        ];

        return Validator::make($data, $rules);
    }
}
