<?php

namespace App\Models\Notes;

/**
 * @OA\Schema(
 *     schema="NoteBcba",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="patient_id", type="integer"),
 *     @OA\Property(property="doctor_id", type="integer", nullable=true),
 *     @OA\Property(property="bip_id", type="integer", nullable=true),
 *     @OA\Property(property="location", type="string", nullable=true),
 *     @OA\Property(property="maladaptives", type="object", nullable=true),
 *     @OA\Property(property="replacements", type="object", nullable=true),
 *     @OA\Property(property="summary_note", type="string", nullable=true),
 *     @OA\Property(property="diagnosis_code", type="string", nullable=true),
 *     @OA\Property(property="birth_date", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="supervisor_id", type="integer", nullable=true),
 *     @OA\Property(property="caregiver_goals", type="object", nullable=true),
 *     @OA\Property(property="rbt_training_goals", type="object", nullable=true),
 *     @OA\Property(property="provider_signature", type="string", nullable=true),
 *     @OA\Property(property="provider_id", type="integer", nullable=true),
 *     @OA\Property(property="supervisor_signature", type="string", nullable=true),
 *     @OA\Property(property="supervisor_name", type="integer", nullable=true),
 *     @OA\Property(property="session_date", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="time_in", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_out", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_in2", type="string", format="time", nullable=true),
 *     @OA\Property(property="time_out2", type="string", format="time", nullable=true),
 *     @OA\Property(property="session_length_total", type="string", format="time", nullable=true),
 *     @OA\Property(property="session_length_total2", type="string", format="time", nullable=true),
 *     @OA\Property(property="environmental_changes", type="string", nullable=true),
 *     @OA\Property(property="meet_with_client_at", type="string", nullable=true),
 *     @OA\Property(property="billedbcba", type="boolean", nullable=true),
 *     @OA\Property(property="paybcba", type="boolean", nullable=true),
 *     @OA\Property(property="mdbcba", type="string", nullable=true),
 *     @OA\Property(property="md2bcba", type="string", nullable=true),
 *     @OA\Property(property="cpt_code", type="string", nullable=true),
 *     @OA\Property(property="status", type="string", nullable=true),
 *     @OA\Property(property="location_id", type="integer", nullable=true),
 *     @OA\Property(property="pa_service_id", type="integer", nullable=true),
 *     @OA\Property(property="insuranceId", type="string", nullable=true),
 *     @OA\Property(
 *         property="provider",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="surname", type="string"),
 *         @OA\Property(property="npi", type="string"),
 *         @OA\Property(property="electronic_signature", type="string")
 *     ),
 *     @OA\Property(
 *         property="supervisor",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="surname", type="string"),
 *         @OA\Property(property="npi", type="string"),
 *         @OA\Property(property="electronic_signature", type="string")
 *     ),
 *     @OA\Property(property="total_minutes", type="integer", nullable=true),
 *     @OA\Property(property="total_units", type="integer", nullable=true),
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

        'maladaptives',//json
        'replacements',//json

        'summary_note',

        'diagnosis_code',
        'birth_date',
        'supervisor_id',
        // 'note_description',


        'caregiver_goals', //json
        'rbt_training_goals', //json

        'provider_signature',
        'provider_id',

        'supervisor_signature',
        'supervisor_name',

        'session_date',
        'session_length_total',
        'session_length_total2',
        'environmental_changes',

        'meet_with_client_at',
        'billedbcba',
        'paybcba',
        'mdbcba',
        'md2bcba',
        'cpt_code',
        'status',
        'location_id',
        'pa_service_id',
        'insuranceId',
    ];

    protected $appends = ['provider', 'supervisor', 'total_units', 'total_minutes'];

    protected $casts = [
        'maladaptives' => 'json',
        'replacements' => 'json',
    ];
}
