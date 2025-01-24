<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

class ConsentToTreatment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'analyst_signature',
        'analyst_signature_date',
        'parent_guardian_signature',
        'parent_guardian_signature_date',
    ];

    protected $casts = [
        'analyst_signature_date' => 'datetime',
        'parent_guardian_signature_date' => 'datetime',
    ];

    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }

    public static function validate($data)
    {
        $rules = [
            'bip_id' => 'required|exists:bips,id',
            'analyst_signature' => 'nullable|string',
            'analyst_signature_date' => 'nullable|date',
            'parent_guardian_signature' => 'nullable|string',
            'parent_guardian_signature_date' => 'nullable|date',
        ];

        return Validator::make($data, $rules);
    }
}
