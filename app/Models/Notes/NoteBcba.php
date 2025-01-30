<?php

namespace App\Models\Notes;

/**
 * @OA\Schema(
 *     schema="NoteBcba",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="insurance_id", type="integer", nullable=true),
 *     @OA\Property(property="patient_id", type="integer", nullable=true),
 *     @OA\Property(property="patient_identifier", type="string", nullable=true),
 *     @OA\Property(property="doctor_id", type="integer", nullable=true),
 *     @OA\Property(property="bip_id", type="integer", nullable=true),
 *     @OA\Property(property="diagnosis_code", type="string", maxLength=50, nullable=true),
 *     @OA\Property(property="cpt_code", type="string", nullable=true),
 *     @OA\Property(property="meet_with_client_at", type="string", nullable=true),
 *     @OA\Property(property="pos", type="string", nullable=true),
 *     @OA\Property(property="participants", type="string", nullable=true),
 *     @OA\Property(property="environmental_changes", type="string", nullable=true),
 *     @OA\Property(property="session_date", type="string", format="Y-m-d", nullable=true),
 *     @OA\Property(property="next_session_is_scheduled_for", type="string", format="Y-m-d", nullable=true),
 *     @OA\Property(property="time_in", type="string", format="H:i", nullable=true),
 *     @OA\Property(property="time_out", type="string", format="H:i", nullable=true),
 *     @OA\Property(property="time_in2", type="string", format="H:i", nullable=true),
 *     @OA\Property(property="time_out2", type="string", format="H:i", nullable=true),
 *     @OA\Property(property="session_length_total", type="number", format="double", nullable=true),
 *     @OA\Property(property="session_length_total2", type="number", format="double", nullable=true),
 *     @OA\Property(property="note_description", type="string", nullable=true),
 *     @OA\Property(property="rendering_provider", type="integer", nullable=true),
 *     @OA\Property(property="supervisor_id", type="integer", nullable=true),
 *     @OA\Property(property="provider_id", type="integer", nullable=true),
 *     @OA\Property(property="provider_signature", type="string", nullable=true),
 *     @OA\Property(property="supervisor_signature", type="string", nullable=true),
 *     @OA\Property(property="status", type="string", enum={"pending", "ok", "no", "review"}, default="pending"),
 *     @OA\Property(property="summary_note", type="string", nullable=true),
 *     @OA\Property(property="billed", type="boolean", default=false),
 *     @OA\Property(property="paid", type="boolean", default=false),
 *     @OA\Property(property="location_id", type="integer", nullable=true),
 *     @OA\Property(property="pa_service_id", type="integer", nullable=true),
 *     @OA\Property(property="insuranceId", type="string", nullable=true),
 *     @OA\Property(property="insurance_identifier", type="string", nullable=true),
 *     @OA\Property(property="md", type="string", maxLength=20, nullable=true),
 *     @OA\Property(property="md2", type="string", maxLength=20, nullable=true),
 *     @OA\Property(property="md3", type="string", maxLength=20, nullable=true),
 *     @OA\Property(property="subtype", type="string", nullable=true),
 *     @OA\Property(property="BCBA_conducted_client_observations", type="boolean", nullable=true),
 *     @OA\Property(property="BCBA_conducted_assessments", type="boolean", nullable=true),
 *     @OA\Property(property="assessment_tools", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="intake_outcome", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="intervention_protocols", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="replacement_protocols", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="modifications_needed_at_this_time", type="boolean", nullable=true),
 *     @OA\Property(property="additional_goals_or_interventions", type="string", nullable=true),
 *     @OA\Property(property="demonstrated_intervention_protocols", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="demonstrated_replacement_protocols", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="behavior_protocols", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="caregiver_goals", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="rbt_training_goals", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 */

class NoteBcba extends Note
{
    protected $fillable = [
        'insurance_id',
        'patient_id',
        'patient_identifier',
        'time_in',
        'time_out',
        'time_in2',
        'time_out2',
        'provider_id',
        'location_id',
        'session_date',
        'cpt_code',
        'status',
        'billed',
        'paid',
        'md',
        'md2',
        'md3',
        'doctor_id',
        'bip_id',
        'summary_note',
        'pa_service_id',
        'participants',
        'summary_note',
        'diagnosis_code',
        'supervisor_id',
        'note_description',
        'rbt_training_goals', //json
        'provider_signature',
        'supervisor_signature',
        'meet_with_client_at',
        'session_length_total',
        'session_length_total2',
        'insuranceId',
        'pos',
        'insurance_identifier',
        'environmental_changes',
        // 97151
        'subtype',
        'BCBA_conducted_client_observations',
        'BCBA_conducted_assessments',
        'assessment_tools',//json
        'intake_outcome',//json
        // 97155
        'intervention_protocols',//json
        'replacement_protocols',//json
        'modifications_needed_at_this_time',
        'additional_goals_or_interventions',
        // 97156
        // 'demonstrated_replacement_protocols',//json
        // 'demonstrated_intervention_protocols',//json
        'behavior_protocols',//json
        'caregiver_goals', //json
    ];

    protected $casts = [
        'caregiver_goals' => 'json',
        'rbt_training_goals' => 'json',
        'intervention_protocols' => 'json',
        'behavior_protocols' => 'json',
        'intake_outcome' => 'json',
        'assessment_tools' => 'json',
        'replacement_protocols' => 'json',
        // 'demonstrated_intervention_protocols' => 'json',
        // 'demonstrated_replacement_protocols' => 'json',
        'billed' => 'boolean',
        'paid' => 'boolean',
        'session_date' => 'date:Y-m-d',
        'next_session_is_scheduled_for' => 'date:Y-m-d',
    ];
}
