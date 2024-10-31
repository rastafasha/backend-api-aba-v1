<?php

namespace App\Models\Bip;
use App\Models\User;
use App\Models\Bip\CrisisPlan;
use App\Models\Bip\Maladaptive;
use App\Models\Patient\Patient;
use App\Models\Bip\ReductionGoal;
use App\Models\Bip\FamilyEnvolment;
use App\Models\Bip\SustitutionGoal;
use App\Models\Bip\BehaviorAsistant;
use App\Models\Bip\ConsentToTreatment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bip\MonitoringEvaluating;
use App\Models\Bip\DeEscalationTechnique;
use App\Models\Bip\GeneralizationTraining;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Bip extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'type_of_assessment',
        'documents_reviewed',
        'client_id',
        'doctor_id',
        'patient_id',
        'background_information',
        'previus_treatment_and_result',
        'current_treatment_and_progress',
        'education_status',
        'phisical_and_medical_status',
        'maladaptives',//json
        'assestment_conducted',
        'assestment_conducted_options',//json
        'prevalent_setting_event_and_atecedents',//json
        'assestmentEvaluationSettings',//json
        'interventions',//json
        'reduction_id',
        'strengths',
        'weakneses',
        'hypothesis_based_intervention',

        'phiysical_and_medical',
        'phiysical_and_medical_status',//json

        'tangibles',//json
        'attention',//json
        'escape',//json
        'sensory',//json

        //no borrar
        // 'behavior',
        // 'hypothesized_functions',
        // 'premack_principal',
        // 'response_block',
        // 'dro',
        // 'dra',
        // 'errorless_teaching',
        // 'redirection',
        // 'ncr',
        // 'shaping',
        // 'chaining',
        // 'maladaptive_id',
    ];

    // protected $casts = [
    //     'documents_reviewed' => 'array',
    //     'maladaptives' => 'array',
    //     'assestment_conducted_options' => 'array',
    //     'prevalent_setting_event_and_atecedents' => 'array',
    //     'interventions' => 'array',
    //     'tangibles' => 'array',
    //     'attention' => 'array',
    //     'escape' => 'array',
    //     'sensory' => 'array',
    //     'phiysical_and_medical_status' => 'array',
    // ];


     public function patient()
    {
        return $this->hasOne(Patient::class, 'patient_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class,"doctor_id");
    }

    //  public function doctors()
    // {
    //     return $this->hasMany(User::class, 'doctor_id');
    // }
    //  public function maladaptive()
    // {
    //     return $this->hasOne(Maladaptive::class, 'maladaptive_id');
    // }
     public function reduction_goals()
    {
        return $this->hasMany(ReductionGoal::class);
    }

    public function sustitution_goals()
    {
        return $this->hasMany(SustitutionGoal::class);
    }

    public function family_envolments()
    {
        return $this->hasMany(FamilyEnvolment::class);
    }

    public function monitoring_evalutatings()
    {
        return $this->hasMany(MonitoringEvaluating::class);
    }


    public function generalization_trainings()
    {
        return $this->hasMany(GeneralizationTraining::class);
    }

    public function crisis_plans()
    {
        return $this->hasMany(CrisisPlan::class);
    }

    public function de_escalation_techniques()
    {
        return $this->hasMany(DeEscalationTechnique::class);
    }

    public function consent_to_treatments()
    {
        return $this->hasMany(ConsentToTreatment::class);
    }







    // public function bip_files(){
    //     return $this->hasMany(BipFile::class, "documents_reviewed");
    // }

    // filtro buscador

    public function scopefilterAdvanceBip($query,
    $patientID,
    $name_doctor,
    $date){

        if($patientID){
            $query->where("patientID", $patientID);
        }

        if($name_doctor){
            $query->whereHas("doctor", function($q)use($name_doctor){
                $q->where("name", "like","%".$name_doctor."%")
                    ->orWhere("surname", "like","%".$name_doctor."%");
            });
        }

        if($date){
            $query->whereDate("date_appointment", Carbon::parse($date)->format("Y-m-d"));
        }
        return $query;
    }
}
