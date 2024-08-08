<?php

namespace App\Models\Notes;

use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoteBcba extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'patient_id',
        'doctor_id',
        'bip_id',
        'location',
        'rendering_provider',

        'diagnosis_code',
        'birth_date',
        'aba_supervisor',
        'note_description',
        
        
        'caregiver_goals',//json
        'rbt_training_goals',//json

        'provider_signature',
        'provider_name',
        'supervisor_signature',
        'supervisor_name',

        'session_date',
        'time_in',
        'time_out',
        'time_in2',
        'time_out2',
        'session_length_total',
        'session_length_total2',
        'environmental_changes',
        
        'meet_with_client_at',
        'billedbcba',
        'paybcba',
        'mdbcba',
        'md2bcba',
        'cpt_code',
        'provider',

    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function supervisor() {
        return $this->belongsTo(User::class,"supervisor_name");
    }

    public function abasupervisor() {
        return $this->belongsTo(User::class,'aba_supervisor');
    }
    public function rendering() {
        return $this->belongsTo(User::class, 'rendering_provider');
    }
    public function tecnico() {
        return $this->belongsTo(User::class, 'provider_name');
    }

    public function bips()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }
}
