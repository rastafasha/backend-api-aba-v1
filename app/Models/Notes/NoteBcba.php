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
 *     @OA\Property(property="diagnosis_code", type="string", maxLength=50, nullable=true),
 *     @OA\Property(property="location", type="string", maxLength=50, nullable=true),
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
 *     @OA\Property(property="billedbcba", type="boolean", default=false),
 *     @OA\Property(property="paybcba", type="boolean", default=false),
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
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mergeFillable($this->extraFillable);
    }

    protected $extraFillable = [
        'doctor_id',
        'bip_id',
        'location',

        'summary_note',

        'diagnosis_code',
        'supervisor_id',
        'note_description',


        'caregiver_goals', //json
        'rbt_training_goals', //json

        'provider_signature',
        'provider_id',

        'supervisor_signature',
        // 'supervisor_name',

        'session_date',
        'session_length_total',
        'session_length_total2',

        'billedbcba',
        'paybcba',
        'cpt_code',
        'status',
        'location_id',
        'pa_service_id',
        'insuranceId',
    ];

    protected $casts = [
        'caregiver_goals' => 'json',
        'rbt_training_goals' => 'json',
    ];

}
