<?php

namespace App\Models\Billing;

use App\Models\User;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Models\Insurance\Insurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory;
    protected $fillable=[
        'patient_id',
        'sponsor_id',
        'cpt_code',
        'insurer_id',
        'insurer_rate',
        'date',
        'total_hours',
        'total_units',
        'billing_total',
        'week_total_hours',
        'week_total_units',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurer_id');
    }

    public function note_rbt()
    {
        return $this->hasMany(NoteRbt::class);
    }
}
