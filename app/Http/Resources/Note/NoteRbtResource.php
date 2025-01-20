<?php

namespace App\Http\Resources\Note;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteRbtResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $morning = date("H:i", strtotime($this->resource->time_out) - strtotime($this->resource->time_in));
        $afternoon = date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2));
        return [
            'id' => $this->resource->id,
            "session_date" => $this->resource->session_date ? Carbon::parse($this->resource->session_date)->format("Y-m-d") : null,
            "next_session_is_scheduled_for" => $this->resource->next_session_is_scheduled_for,

            "interventions" =>
            is_string($this->resource->interventions)
                ? json_decode($this->resource->interventions) : $this->resource->interventions,

            "replacements" =>
            is_string($this->resource->replacements)
                ? json_decode($this->resource->replacements) : $this->resource->replacements,

            "maladaptives" =>
            is_string($this->resource->maladaptives)
                ? json_decode($this->resource->maladaptives) : $this->resource->maladaptives,

            "summary_note" => $this->resource->summary_note,

            "participants" => $this->resource->participants,
            "bip_id" => $this->resource->bip_id,
            "pos" => $this->resource->pos,
            "environmental_changes" => $this->resource->environmental_changes,
            "provider_credential" => $this->resource->provider_credential,
            "provider_id" => $this->resource->provider_id,
            "supervisor_id" => $this->resource->supervisor_id,

            "patient_id" => $this->resource->patient_id,
            'patient_identifier' => $this->resource->patient_identifier,
            "doctor_id" => $this->resource->doctor_id,
            "meet_with_client_at" => $this->resource->meet_with_client_at,

            "time_in" => $this->resource->time_in ? Carbon::parse($this->resource->time_in)->format(" H:i:s") : null,
            "time_out" => $this->resource->time_out ? Carbon::parse($this->resource->time_out)->format(" H:i:s") : null,
            "time_in2" => $this->resource->time_in2 ? Carbon::parse($this->resource->time_in2)->format(" H:i:s") : null,
            "time_out2" => $this->resource->time_out2 ? Carbon::parse($this->resource->time_out2)->format(" H:i:s") : null,
            // al obtener las horas trabajadas se suman
            //convertimos las horas para poder sumarlas
            //sumamos la hora de inicio con la hora final y le restamos los minutos de descanso.
            "session_length_morning_total" => $morning,
            "session_length_afternon_total" => $afternoon,

            // "session_length_total" => $morning + $afternoon,// da error numerico
            // "session_length_morning_total" => date("H:i", strtotime($this->resource->time_out) - strtotime($this->resource->time_in) ),
            // "session_length_afternon_total" => date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2) ),

            "session_length_total" =>
            date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2) + strtotime($this->resource->time_out) - strtotime($this->resource->time_in)),

            "total_hours" =>
            $this->calculateTotalHours(),

            "client_appeared" => $this->resource->client_appeared,
            "as_evidenced_by" => $this->resource->as_evidenced_by,
            "rbt_modeled_and_demonstrated_to_caregiver" => $this->resource->rbt_modeled_and_demonstrated_to_caregiver,
            "client_response_to_treatment_this_session" => $this->resource->client_response_to_treatment_this_session,
            "progress_noted_this_session_compared_to_previous_session" => $this->resource->progress_noted_this_session_compared_to_previous_session,


            "provider_signature" => $this->resource->provider_signature ? $this->resource->provider_signature : null,

            // "provider_signature" => $this->resource->provider_signature ? env("APP_URL") . $this->resource->provider_signature : null,

            // "provider_signature" => $this->resource->provider_signature,
            "provider_name" => $this->resource->provider_name,

            "pa_service_id" => $this->resource->pa_service_id,

            // "supervisor_signature" => $this->resource->supervisor_signature ? env("APP_URL") . $this->resource->supervisor_signature : null,
            "supervisor_signature" => $this->resource->supervisor_signature ? $this->resource->supervisor_signature : null,

            "supervisor_name" => $this->resource->supervisor_name,
            'supervisor' => $this->when($this->resource->supervisor, function () {
                return [
                    'id' => $this->resource->supervisor->id,
                    'name' => $this->resource->supervisor->name,
                    'surname' => $this->resource->supervisor->surname,
                    'npi' => $this->resource->supervisor->npi,
                ];
            }),

            "provider_name_g" => $this->resource->provider_name_g,
            "billed" => $this->resource->billed,
            "pay" => $this->resource->pay,
            "status" => $this->resource->status,
            "md" => $this->resource->md,
            "md2" => $this->resource->md2,
            "md3" => $this->resource->md3,
            "cpt_code" => $this->resource->cpt_code,
            "insuranceId" => $this->resource->insuranceId,
            "provider" => $this->resource->provider,
            "location_id" => $this->resource->location_id,

            "total_minutes" => $this->resource->total_minutes,
            "total_units" => $this->resource->total_units,

            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d H:i:s") : null,
            "updated_at" => $this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->format("Y-m-d H:i:s") : null,
        ];
    }

    /**
     * Calculate the total hours worked.
     *
     * @return string
     */
    private function calculateTotalHours()
    {
        $totalSeconds = 0;

        if ($this->resource->time_in && $this->resource->time_out) {
            $totalSeconds += Carbon::parse($this->resource->time_out)->diffInSeconds(Carbon::parse($this->resource->time_in));
        }

        if ($this->resource->time_in2 && $this->resource->time_out2) {
            $totalSeconds += Carbon::parse($this->resource->time_out2)->diffInSeconds(Carbon::parse($this->resource->time_in2));
        }

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);

        return sprintf("%02d:%02d", $hours, $minutes);
    }
}
