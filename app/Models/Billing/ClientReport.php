<?php

namespace App\Models\Billing;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Notes\NoteRbt;
use App\Models\Notes\NoteBcba;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\DB;
use App\Models\Insurance\Insurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_identifier',
        'sponsor_id',
        'insurer_id',
        'note_rbt_id',
        'note_bcba_id',
        'chargesrbt',
        'chargesbcba',
        'billed',
        'billedbcba',
        'cpt_code',

        'md',
        'md2',
        'md3',
        'mdbcba',
        'md2bcba',
        'md3bcba',

        'n_units',
        'pa_number',
        'pay',
        'paybcba',
        'pos',
        'session_date',
        'total_hours',
        'xe',
        'npi',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_identifier');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurer_id');
    }
    public function note_rbt()
    {
        return $this->belongsTo(NoteRbt::class, 'note_rbt_id');
    }
    public function note_bcba()
    {
        return $this->belongsTo(NoteBcba::class, 'note_bcba_id');
    }


    public function scopefilterAdvanceClient(
        $query,
        $search_doctor,
        $search_patient,
        $date_start,
        $date_end
    ) {


        if ($search_doctor) {
            $query->whereHas("doctor", function ($q) use ($search_doctor) {
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"), "like", "%" . $search_doctor . "%");
            });
        }
        if ($search_patient) {
            $query->whereHas("patient", function ($q) use ($search_patient) {
                $q->where(DB::raw("CONCAT(patients.name,' ',IFNULL(patients.surname,''),' ',IFNULL(patients.email,''))"), "like", "%" . $search_patient . "%");
            });
        }

        if ($date_start && $date_end) {
            $query->whereBetween("date_appointment", [
                Carbon::parse($date_start)->format("Y-m-d"),
                Carbon::parse($date_end)->format("Y-m-d"),
            ]);
        }
        return $query;
    }
}
