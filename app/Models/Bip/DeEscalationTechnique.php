<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class DeEscalationTechnique extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'description',
        'service_recomendation',
        'recomendation_lists',//json


    ];

    protected $casts = [
        'recomendation_lists' => 'array',
    ];

    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public static function validate($data)
    {
        $rules = [
            'bip_id' => 'required|exists:bips,id',
            'description' => 'nullable|string',
            'service_recomendation' => 'nullable|string',
            'recomendation_lists' => 'nullable|array',
            'recomendation_lists.*.cpt' => 'nullable|string',
            'recomendation_lists.*.location' => 'nullable|string',
            'recomendation_lists.*.num_units' => 'nullable|integer',
            'recomendation_lists.*.breakdown_per_week' => 'nullable|string',
            'recomendation_lists.*.description_service' => 'nullable|string',
        ];

        return Validator::make($data, $rules);
    }
}
