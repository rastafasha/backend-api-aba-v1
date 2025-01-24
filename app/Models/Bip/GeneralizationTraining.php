<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class GeneralizationTraining extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
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

    public static function validate($data)
    {
        $rules = [
            'bip_id' => 'required|exists:bips,id',
            'discharge_plan' => 'nullable|string',
            'transition_fading_plans' => 'nullable|array',
            'transition_fading_plans.*.transition_plan' => 'nullable|string',
            'transition_fading_plans.*.fading_plan' => 'nullable|string',
            'transition_fading_plans.*.timeline' => 'nullable|string',
        ];
        return Validator::make($data, $rules);
    }
}
