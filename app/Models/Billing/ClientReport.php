<?php

namespace App\Models\Billing;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Notes\NoteRbt;
use App\Models\Patient\Patient;
use App\Models\Insurance\Insurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientReport extends Model
{
    use HasFactory;
    protected $fillable=[
        'patient_id',
        'sponsor_id',
        'charges',
        'billed',
        'cpt_code',
        'insurer_id',
        'md',
        'md2',
        'n_units',
        'pa_number',
        'pay',
        'pos',
        'session_date',
        'total_hours',
        'xe',
        'npi',
    ];


    public function patient()
    {
        return $this->hasMany(Patient::class);
    }
    public function doctor()
    {
        return $this->hasMany(User::class);
    }

    public function insurance()
    {
        return $this->hasMany(Insurance::class);
    }
    public function note_rbt()
    {
        return $this->belongsTo(NoteRbt::class);
    }

     // filtro buscador

    //  public function scopefilterAdvance($query, $name_doctor, $session_date){
        
    //     if($name_doctor){
    //         $query->whereHas("doctor", function($q)use($name_doctor){
    //             $q->where("name", "like","%".$name_doctor."%")
    //                 ->orWhere("surname", "like","%".$name_doctor."%");
    //         });
    //     }

    //     if($session_date){
    //         $query->whereDate("session_date", Carbon::parse($session_date)->format("Y-m-d"));
    //     }
    //     return $query;
    // }

    public function scopefilterAdvanceClient($query,$search_doctor, $search_patient,
    $date_start,$date_end){
        

        if($search_doctor){
            $query->whereHas("doctor", function($q)use($search_doctor){
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"),"like","%".$search_doctor."%");
                   
            });
        }
        if($search_patient){
            $query->whereHas("patient", function($q)use($search_patient){
                $q->where(DB::raw("CONCAT(patients.name,' ',IFNULL(patients.surname,''),' ',IFNULL(patients.email,''))"),"like","%".$search_patient."%");
                
            });
        }

        if($date_start && $date_end){
            $query->whereBetween("date_appointment", [
                Carbon::parse($date_start)->format("Y-m-d"),
                Carbon::parse($date_end)->format("Y-m-d"),
            ]);
        }
        return $query;
    }
}
