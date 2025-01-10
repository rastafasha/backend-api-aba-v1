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
use App\Models\Bip\Maladaptive;
use App\Models\Bip\Replacement;

/**
 * @OA\Schema(
 *     schema="GeneralizationTraining",
 *     title="GeneralizationTraining",
 *     description="Model for documenting how skills are generalized across different settings and environments",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this training belongs to"),
 *     @OA\Property(property="patient_identifier", type="string", example="PAT123", description="Patient identifier"),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1, description="ID of the client"),
 *     @OA\Property(property="discharge_plan", type="string", description="Plan for discharge and transition"),
 *     @OA\Property(
 *         property="transition_fading_plans",
 *         type="array",
 *         description="List of transition and fading plans",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="phase", type="string", example="Phase 1"),
 *             @OA\Property(property="description", type="string", example="Initial transition phase")
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */

/**
 * @OA\Schema(
 *     schema="CrisisPlan",
 *     title="CrisisPlan",
 *     description="Model for documenting crisis intervention procedures and risk assessments",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this plan belongs to"),
 *     @OA\Property(property="patient_identifier", type="string", example="PAT123", description="Patient identifier"),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1, description="ID of the client"),
 *     @OA\Property(property="crisis_description", type="string", description="Detailed description of potential crisis situations"),
 *     @OA\Property(property="crisis_note", type="string", description="Additional notes about crisis management"),
 *     @OA\Property(property="caregiver_requirements_for_prevention_of_crisis", type="string", description="Requirements for caregivers to prevent crises"),
 *     @OA\Property(
 *         property="risk_factors",
 *         type="array",
 *         description="List of identified risk factors",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="do_not_apply", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Property(
 *         property="suicidalities",
 *         type="array",
 *         description="Suicidal risk assessment factors",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="not_present", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Property(
 *         property="homicidalities",
 *         type="array",
 *         description="Homicidal risk assessment factors",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="not_present_homicidality", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */

/**
 * @OA\Schema(
 *     schema="DeEscalationTechnique",
 *     title="DeEscalationTechnique",
 *     description="Model for documenting techniques used to prevent and manage escalating behaviors",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this technique belongs to"),
 *     @OA\Property(property="patient_identifier", type="string", example="PAT123", description="Patient identifier"),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1, description="ID of the client"),
 *     @OA\Property(property="description", type="string", description="Description of the de-escalation technique"),
 *     @OA\Property(property="service_recomendation", type="string", description="Service recommendations"),
 *     @OA\Property(
 *         property="recomendation_lists",
 *         type="array",
 *         description="List of specific recommendations",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="cpt", type="string", example="97151", description="CPT code"),
 *             @OA\Property(property="location", type="string", example="In Home/School", description="Location where technique is applied"),
 *             @OA\Property(property="num_units", type="integer", example=32, description="Number of units"),
 *             @OA\Property(property="breakdown_per_week", type="string", example="8", description="Weekly breakdown"),
 *             @OA\Property(property="description_service", type="string", example="Assessment", description="Service description")
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */

/**
 * @OA\Schema(
 *     schema="ConsentToTreatment",
 *     title="ConsentToTreatment",
 *     description="Model for documenting patient/guardian consent for treatments",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this consent belongs to"),
 *     @OA\Property(property="patient_id", type="string", example="PAT123", description="Patient identifier"),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1, description="ID of the client"),
 *     @OA\Property(property="analyst_signature", type="string", description="Path to analyst's signature file"),
 *     @OA\Property(property="analyst_signature_date", type="string", format="datetime", description="Date of analyst's signature"),
 *     @OA\Property(property="parent_guardian_signature", type="string", description="Path to parent/guardian's signature file"),
 *     @OA\Property(property="parent_guardian_signature_date", type="string", format="datetime", description="Date of parent/guardian's signature"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */

/**
 * @OA\Schema(
 *     schema="Bip",
 *     title="Bip",
 *     description="Behavior Intervention Plan (BIP) model. Contains all information about a patient's behavior intervention plan, " .
 *         "including plans, objectives, and related data.",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="patient_identifier", type="string", example="PAT123", description="Unique identifier for the patient"),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1, description="ID of the client this BIP belongs to"),
 *     @OA\Property(property="doctor_id", type="integer", format="int64", nullable=true, example=1, description="ID of the supervising doctor"),
 *     @OA\Property(property="type_of_assessment", type="integer", format="int32", example=3, description="Type of assessment performed"),
 *     @OA\Property(property="documents_reviewed", type="array", @OA\Items(type="string"), nullable=true, description="List of documents reviewed during assessment"),
 *     @OA\Property(property="background_information", type="string", nullable=true, description="Patient's background information"),
 *     @OA\Property(property="previus_treatment_and_result", type="string", nullable=true, description="History of previous treatments and their outcomes"),
 *     @OA\Property(property="current_treatment_and_progress", type="string", nullable=true, description="Current treatment details and progress"),
 *     @OA\Property(property="education_status", type="string", nullable=true, description="Patient's educational background and status"),
 *     @OA\Property(property="phisical_and_medical_status", type="string", nullable=true, description="Patient's physical and medical conditions"),
 *     @OA\Property(property="strengths", type="string", nullable=true, description="Patient's identified strengths"),
 *     @OA\Property(property="weakneses", type="string", nullable=true, description="Patient's identified weaknesses"),
 *     @OA\Property(property="phiysical_and_medical", type="string", nullable=true, description="Detailed physical and medical information"),
 *     @OA\Property(property="phiysical_and_medical_status", type="array", @OA\Items(type="string"), nullable=true, description="List of physical and medical conditions"),
 *     @OA\Property(property="assestment_conducted", type="string", nullable=true, description="Details of conducted assessments"),
 *     @OA\Property(property="assestment_conducted_options", type="array", @OA\Items(type="string"), nullable=true, description="Types of assessments performed"),
 *     @OA\Property(property="assestmentEvaluationSettings", type="array", @OA\Items(type="string"), nullable=true, description="Settings where assessments were conducted"),
 *     @OA\Property(property="prevalent_setting_event_and_atecedents", type="array", @OA\Items(type="string"), nullable=true, description="Common triggers and antecedents"),
 *     @OA\Property(property="hypothesis_based_intervention", type="string", nullable=true, description="Intervention strategy based on behavioral hypothesis"),
 *     @OA\Property(property="interventions", type="array", @OA\Items(type="string"), nullable=true, description="List of planned interventions"),
 *     @OA\Property(property="tangibles", type="array", @OA\Items(type="string"), nullable=true, description="Tangible reinforcers"),
 *     @OA\Property(property="attention", type="array", @OA\Items(type="string"), nullable=true, description="Attention-based interventions"),
 *     @OA\Property(property="escape", type="array", @OA\Items(type="string"), nullable=true, description="Escape-related behaviors and interventions"),
 *     @OA\Property(property="sensory", type="array", @OA\Items(type="string"), nullable=true, description="Sensory-related behaviors and interventions"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, description="Soft delete timestamp"),
 *     @OA\Property(
 *         property="maladaptives",
 *         type="array",
 *         description="Collection of maladaptive behavior plans. These plans focus on reducing problematic behaviors.",
 *         @OA\Items(ref="#/components/schemas/Plan")
 *     ),
 *     @OA\Property(
 *         property="replacements",
 *         type="array",
 *         description="Collection of replacement behavior plans. These plans focus on teaching and increasing appropriate behaviors.",
 *         @OA\Items(ref="#/components/schemas/Plan")
 *     ),
 *     @OA\Property(
 *         property="caregiver_trainings",
 *         type="array",
 *         description="Collection of caregiver training plans. These plans focus on teaching caregivers effective strategies.",
 *         @OA\Items(ref="#/components/schemas/Plan")
 *     ),
 *     @OA\Property(
 *         property="rbt_trainings",
 *         type="array",
 *         description="Collection of RBT training plans. These plans focus on training Registered Behavior Technicians.",
 *         @OA\Items(ref="#/components/schemas/Plan")
 *     ),
 *     @OA\Property(
 *         property="generalization_trainings",
 *         type="array",
 *         description="Collection of generalization training records. These document how skills are generalized across settings.",
 *         @OA\Items(ref="#/components/schemas/GeneralizationTraining")
 *     ),
 *     @OA\Property(
 *         property="crisis_plans",
 *         type="array",
 *         description="Collection of crisis plans. These detail procedures for handling crisis situations.",
 *         @OA\Items(ref="#/components/schemas/CrisisPlan")
 *     ),
 *     @OA\Property(
 *         property="de_escalation_techniques",
 *         type="array",
 *         description="Collection of de-escalation techniques. These detail strategies to prevent and manage escalating behaviors.",
 *         @OA\Items(ref="#/components/schemas/DeEscalationTechnique")
 *     ),
 *     @OA\Property(
 *         property="consent_to_treatments",
 *         type="array",
 *         description="Collection of consent to treatment records. These document patient/guardian consent for treatments.",
 *         @OA\Items(ref="#/components/schemas/ConsentToTreatment")
 *     )
 * )
 */
class Bip extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CreatedAtFilterable;

    protected $table = 'bips';

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
        // 'maladaptives', //json
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
        // 'maladaptives' => 'json',
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

    public function client()
    {
        return $this->belongsTo(Patient::class, 'client_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, "doctor_id")->select('id', 'name', 'surname', 'npi');
    }

    //  public function doctors()
    // {
    //     return $this->hasMany(User::class, 'doctor_id');
    // }
    //  public function maladaptive()
    // {
    //     return $this->hasOne(Maladaptive::class, 'maladaptive_id');
    // }
    // public function reduction_goals()
    // {
    //     return $this->hasMany(ReductionGoal::class, 'bip_id');
    // }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'bip_id');
    }

    public function maladaptives()
    {
        return $this->hasMany(Plan::class, 'bip_id')->where('category', 'maladaptive');
    }

    public function replacements()
    {
        return $this->hasMany(Plan::class, 'bip_id')->where('category', 'replacement');
    }

    public function caregiver_trainings()
    {
        return $this->hasMany(Plan::class, 'bip_id')->where('category', 'caregiver_training');
    }

    public function rbt_trainings()
    {
        return $this->hasMany(Plan::class, 'bip_id')->where('category', 'rbt_training');
    }

    public function generalization_trainings()
    {
        return $this->hasMany(GeneralizationTraining::class, 'bip_id');
    }

    public function crisis_plans()
    {
        return $this->hasMany(CrisisPlan::class, 'bip_id');
    }

    public function de_escalation_techniques()
    {
        return $this->hasMany(DeEscalationTechnique::class, 'bip_id');
    }

    public function consent_to_treatments()
    {
        return $this->hasMany(ConsentToTreatment::class, 'bip_id');
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
