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
        return $this->hasMany(Patient::class);
    }
    public function sponsor()
    {
        return $this->hasMany(User::class);
    }

    public function insurance()
    {
        return $this->hasMany(Insurance::class);
    }
    public function note_rbt()
    {
        return $this->hasMany(NoteRbt::class);
    }
}
