<?php

namespace App\Models\Notes;

/**
 * @OA\Schema(
 *     schema="NoteBcba",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="insurance_id", type="integer", nullable=true),
 *     @OA\Property(property="patient_id", type="string", nullable=true),
 *     @OA\Property(property="doctor_id", type="integer", nullable=true),
 *     @OA\Property(property="bip_id", type="integer", nullable=true),
 *     @OA\Property(property="participants", type="string", nullable=true),
 *     @OA\Property(property="pos", type="string", nullable=true),
 *     @OA\Property(property="insurance_identifier", type="string", nullable=true),
 *     @OA\Property(property="diagnosis_code", type="string", maxLength=50, nullable=true),
 *     @OA\Property(property="meet_with_client_at", type="string", nullable=true),
 *     @OA\Property(property="session_date", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="time_in", type="string", format="H:i:s", nullable=true),
 *     @OA\Property(property="time_out", type="string", format="H:i:s", nullable=true),
 *     @OA\Property(property="time_in2", type="string", format="H:i:s", nullable=true),
 *     @OA\Property(property="time_out2", type="string", format="H:i:s", nullable=true),
 *     @OA\Property(property="session_length_total", type="number", format="double", nullable=true),
 *     @OA\Property(property="note_description", type="string", nullable=true),
 *     @OA\Property(property="rendering_provider", type="integer", nullable=true),
 *     @OA\Property(property="supervisor_id", type="integer", nullable=true),
 *     @OA\Property(property="caregiver_goals", type="object", nullable=true),
 *     @OA\Property(property="rbt_training_goals", type="object", nullable=true),
 *     @OA\Property(property="provider_signature", type="string", nullable=true),
 *     @OA\Property(property="provider_id", type="integer", nullable=true),
 *     @OA\Property(property="supervisor_signature", type="string", nullable=true),
 *     @OA\Property(property="status", type="string", enum={"pending", "ok", "no", "review"}, default="pending"),
 *     @OA\Property(property="summary_note", type="string", nullable=true),
 *     @OA\Property(property="billed", type="boolean", default=false),
 *     @OA\Property(property="paid", type="boolean", default=false),
 *     @OA\Property(property="cpt_code", type="string", nullable=true),
 *     @OA\Property(property="location_id", type="integer", nullable=true),
 *     @OA\Property(property="pa_service_id", type="integer", nullable=true),
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
        'caregiver_goals', //json
        'rbt_training_goals', //json
        'provider_signature',
        'supervisor_signature',
        'meet_with_client_at',
        // 'supervisor_name',
        'session_length_total',
        'session_length_total2',
        'insuranceId',
        'pos',
        'insurance_identifier',
    ];

    protected $casts = [
        'caregiver_goals' => 'json',
        'rbt_training_goals' => 'json',
        'billed' => 'boolean',
        'paid' => 'boolean',
        'session_date' => 'date:Y-m-d',
    ];
}
