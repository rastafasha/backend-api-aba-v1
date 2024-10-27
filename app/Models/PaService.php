<?php

namespace App\Models;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'pa_services',
        'cpt',
        'n_units',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
