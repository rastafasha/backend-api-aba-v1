<?php

namespace App\Models\Bip;

use App\Models\User;
use App\Models\Bip\CrisisPlan;
use App\Models\Patient\Patient;
use App\Models\Bip\ReductionGoal;
use App\Models\Bip\FamilyEnvolment;
use App\Models\Bip\SustitutionGoal;
use App\Models\Bip\ConsentToTreatment;
use App\Traits\CreatedAtFilterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bip\MonitoringEvaluating;
use App\Models\Bip\DeEscalationTechnique;
use App\Models\Bip\GeneralizationTraining;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @OA\Schema(
 *     schema="Bip",
 *     title="Bip",
 *     description="Behavior Intervention Plan model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="patient_id", type="string", maxLength=50, nullable=true, example="PAT123"),
 *     @OA\Property(property="doctor_id", type="integer", format="int64", nullable=true, example=1),
 *     @OA\Property(property="type_of_assessment", type="integer", format="int32", example=3),
 *     @OA\Property(property="documents_reviewed", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="background_information", type="string", nullable=true),
 *     @OA\Property(property="previus_treatment_and_result", type="string", nullable=true),
 *     @OA\Property(property="current_treatment_and_progress", type="string", nullable=true),
 *     @OA\Property(property="education_status", type="string", nullable=true),
 *     @OA\Property(property="phisical_and_medical_status", type="string", nullable=true),
 *     @OA\Property(property="strengths", type="string", nullable=true),
 *     @OA\Property(property="weakneses", type="string", nullable=true),
 *     @OA\Property(property="phiysical_and_medical", type="string", nullable=true),
 *     @OA\Property(property="phiysical_and_medical_status", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="maladaptives", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="assestment_conducted", type="string", nullable=true),
 *     @OA\Property(property="assestment_conducted_options", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="assestmentEvaluationSettings", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="prevalent_setting_event_and_atecedents", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="hypothesis_based_intervention", type="string", nullable=true),
 *     @OA\Property(property="interventions", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="tangibles", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="attention", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="escape", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="sensory", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 */
class Bip extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CreatedAtFilterable;

    protected $fillable = [
        'type_of_assessment',
        'documents_reviewed',
        'client_id',
        'doctor_id',
        'patient_identifier',
        'background_information',
        'previus_treatment_and_result',
        'current_treatment_and_progress',
        'education_status',
        'phisical_and_medical_status',
        'maladaptives', //json
        'assestment_conducted',
        'assestment_conducted_options', //json
        'prevalent_setting_event_and_atecedents', //json
        'assestmentEvaluationSettings', //json
        'interventions', //json
        'reduction_id',
        'strengths',
        'weakneses',
        'hypothesis_based_intervention',

        'phiysical_and_medical',
        'phiysical_and_medical_status', //json

        'tangibles', //json
        'attention', //json
        'escape', //json
        'sensory', //json

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

    protected $casts = [
        'documents_reviewed' => 'json',
        'maladaptives' => 'json',
        'assestment_conducted_options' => 'json',
        'prevalent_setting_event_and_atecedents' => 'json',
        'interventions' => 'json',
        'tangibles' => 'json',
        'attention' => 'json',
        'escape' => 'json',
        'sensory' => 'json',
        'phiysical_and_medical_status' => 'json',
    ];


    public function patient()
    {
        return $this->hasOne(Patient::class, 'patient_identifier', 'patient_identifier');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, "doctor_id");
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

    public function scopefilterAdvanceBip(
        $query,
        $patientID,
        $name_doctor,
        $date
    ) {

        if ($patientID) {
            $query->where("patientID", $patientID);
        }

        if ($name_doctor) {
            $query->whereHas("doctor", function ($q) use ($name_doctor) {
                $q->where("name", "like", "%" . $name_doctor . "%")
                    ->orWhere("surname", "like", "%" . $name_doctor . "%");
            });
        }

        if ($date) {
            $query->whereDate("date_appointment", Carbon::parse($date)->format("Y-m-d"));
        }
        return $query;
    }
}
