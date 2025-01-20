<?php

namespace App\Models\Notes;

use App\Models\Notes\Note;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="NoteRbt",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="session_date", type="string", format="date", example="2024-11-05"),
 *     @OA\Property(property="next_session_is_scheduled_for", type="string", format="date-time", example="2024-11-12 14:43:31"),
 *     @OA\Property(
 *         property="interventions",
 *         type="object",
 *         @OA\Property(property="positive_reinforcement", type="boolean", example=true),
 *         @OA\Property(property="prompting", type="boolean", example=true),
 *         @OA\Property(property="redirection", type="boolean", example=true)
 *     ),
 *     @OA\Property(
 *         property="replacements",
 *         type="object",
 *         @OA\Property(property="verbal_requests", type="integer", example=5),
 *         @OA\Property(property="waiting_quietly", type="integer", example=4)
 *     ),
 *     @OA\Property(
 *         property="maladaptives",
 *         type="object",
 *         @OA\Property(property="tantrums", type="integer", example=3),
 *         @OA\Property(property="aggression", type="integer", example=1)
 *     ),
 *     @OA\Property(property="bip_id", type="integer", example=1),
 *     @OA\Property(property="insurance_identifier", type="string", example="123456789"),
 *     @OA\Property(property="pos", type="string", example="12"),
 *     @OA\Property(property="environmental_changes", type="string", example="None noted"),
 *     @OA\Property(property="provider_credential", type="string", example="RBT"),
 *     @OA\Property(property="patient_id", type="string", example="PAT001"),
 *     @OA\Property(property="doctor_id", type="integer", example=3),
 *     @OA\Property(property="meet_with_client_at", type="string", example="Home"),
 *     @OA\Property(property="participants", type="string", example="Home"),
 *     @OA\Property(property="time_in", type="string", example=" 09:00:00"),
 *     @OA\Property(property="time_out", type="string", example=" 11:00:00"),
 *     @OA\Property(property="time_in2", type="string", nullable=true),
 *     @OA\Property(property="time_out2", type="string", nullable=true),
 *     @OA\Property(property="session_length_morning_total", type="string", example="02:00"),
 *     @OA\Property(property="session_length_afternon_total", type="string", example="00:00"),
 *     @OA\Property(property="session_length_total", type="string", example="02:00"),
 *     @OA\Property(property="total_hours", type="string", example="02:00"),
 *     @OA\Property(property="client_appeared", type="string", example="Alert and engaged"),
 *     @OA\Property(property="as_evidenced_by", type="string", example="Active participation in activities"),
 *     @OA\Property(property="rbt_modeled_and_demonstrated_to_caregiver", type="string", example="Positive reinforcement techniques"),
 *     @OA\Property(property="client_response_to_treatment_this_session", type="string", example="Client showed good progress with verbal requests"),
 *     @OA\Property(property="progress_noted_this_session_compared_to_previous_session", type="string", example="Improvement in communication skills"),
 *     @OA\Property(property="provider_signature", type="string", example="Alice RBT"),
 *     @OA\Property(property="provider_name", type="string", nullable=true),
 *     @OA\Property(property="pa_service_id", type="integer", nullable=true),
 *     @OA\Property(property="supervisor_signature", type="string", example="Sarah BCBA"),
 *     @OA\Property(property="supervisor_name", type="integer", example=3),
 *     @OA\Property(
 *         property="supervisor",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=3),
 *         @OA\Property(property="name", type="string", example="Sarah BCBA"),
 *         @OA\Property(property="surname", type="string", nullable=true),
 *         @OA\Property(property="npi", type="string", example="1234567890"),
 *         @OA\Property(property="electronic_signature", type="string", example="signatures/example.png")
 *     ),
 *     @OA\Property(property="provider_name_g", type="string", nullable=true),
 *     @OA\Property(property="billed", type="integer", example=0),
 *     @OA\Property(property="paid", type="integer", example=0),
 *     @OA\Property(property="status", type="string", example="ok"),
 *     @OA\Property(property="summary_note", type="string", nullable=true),
 *     @OA\Property(property="cpt_code", type="string", example="97153"),
 *     @OA\Property(property="insuranceId", type="string", nullable=true),
 *     @OA\Property(
 *         property="provider",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=5),
 *         @OA\Property(property="name", type="string", example="Alice RBT"),
 *         @OA\Property(property="surname", type="string", nullable=true),
 *         @OA\Property(property="npi", type="string", nullable=true),
 *         @OA\Property(property="electronic_signature", type="string", example="signatures/example.png")
 *     ),
 *     @OA\Property(property="location_id", type="integer", example=1),
 *     @OA\Property(property="total_minutes", type="integer", example=120),
 *     @OA\Property(property="total_units", type="integer", example=8),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-10 14:43:31"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-10 14:43:31")
 * )
 */
class NoteRbt extends Note
{
    protected $fillable = [
        'insurance_id',
        'patient_id',
        'patient_identifier',
        'participants',
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
        'session_length_total',
        'environmental_changes',
        'maladaptives',
        'replacements',
        'interventions',
        'meet_with_client_at',
        'client_appeared',
        'as_evidenced_by',
        'rbt_modeled_and_demonstrated_to_caregiver',
        'client_response_to_treatment_this_session',
        'progress_noted_this_session_compared_to_previous_session',
        'next_session_is_scheduled_for',
        // 'provider_name_g',
        // 'provider_name',
        'provider_signature',
        'provider_credential',
        'supervisor_signature',
        'supervisor_name',
        'supervisor_id',
        'insuranceId',
        'pos',
        'insurance_identifier',
    ];

    protected $casts = [
        'maladaptives' => 'json',
        'replacements' => 'json',
        'interventions' => 'json',
        'billed' => 'boolean',
        'paid' => 'boolean',
        'session_date' => 'date:Y-m-d',
        'next_session_is_scheduled_for' => 'date:Y-m-d',
    ];


    public function scopefilterAdvanceClientReport(
        $query,
        // $speciality_id,
        $search_doctor,
        $search_tecnicoRbt,
        $search_supervisor,
        // $search_patient,
        $date_start,
        $date_end
    ) {

        // if($speciality_id){
        //     $query->where("speciality_id", $speciality_id);
        // }

        if ($search_doctor) {
            $query->whereHas("doctor", function ($q) use ($search_doctor) {
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"), "like", "%" . $search_doctor . "%");
            });
        }
        if ($search_tecnicoRbt) {
            $query->whereHas("doctor", function ($q) use ($search_tecnicoRbt) {
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"), "like", "%" . $search_tecnicoRbt . "%");
            });
        }
        if ($search_supervisor) {
            $query->whereHas("doctor", function ($q) use ($search_supervisor) {
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"), "like", "%" . $search_supervisor . "%");
            });
        }
        // if($search_patient){
        //     $query->whereHas("patient", function($q)use($search_patient){
        //         $q->where(DB::raw("CONCAT(patients.name,' ',IFNULL(patients.surname,''),' ',IFNULL(patients.email,''))"),"like","%".$search_patient."%");

        //     });
        // }

        if ($date_start && $date_end) {
            $query->whereBetween("session_date", [
                Carbon::parse($date_start)->format("Y-m-d"),
                Carbon::parse($date_end)->format("Y-m-d"),
            ]);
        }
        return $query;
    }
}
