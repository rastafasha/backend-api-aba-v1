<?php

namespace App\Http\Resources\Note;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteBcbaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            "bip_id" => $this->resource->bip_id,
            "patient_id" => $this->resource->patient_id,
            'patient_identifier' => $this->resource->patient_identifier,
            "doctor_id" => $this->resource->doctor_id,
            // "note_description" => $this->resource->note_description,

            "caregiver_goals" =>
            is_string($this->resource->caregiver_goals)
                ? json_decode($this->resource->caregiver_goals) : $this->resource->caregiver_goals,
                "rbt_training_goals" =>
            is_string($this->resource->rbt_training_goals)
                ? json_decode($this->resource->rbt_training_goals) : $this->resource->rbt_training_goals,

            "location" => $this->resource->location,

            "pa_service_id" => $this->resource->pa_service_id,

            "summary_note" => $this->resource->summary_note,

            // "birth_date" => $this->resource->birth_date,
            "birth_date" => $this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y-m-d") : null,
            "aba_supervisor" => $this->resource->aba_supervisor,
            "cpt_code" => $this->resource->cpt_code,
            "diagnosis_code" => $this->resource->diagnosis_code,

            // "rendering_provider" => $this->resource->rendering_provider,
            // // 'rendering'=>$this->resource-> rendering,
            // 'rendering' => [
            //     // 'id'=> $this->resource->rendering->rendering_provider,
            //     'name' => $this->resource->rendering->name,
            //     'surname' => $this->resource->rendering->surname,
            //     'npi' => $this->resource->rendering->npi,
            // ],
            // "provider_signature"=> $this->resource->provider_signature ? env("APP_URL")."storage/".$this->resource->provider_signature : null,

            // "provider_signature" => $this->resource->provider_signature ? env("APP_URL") . $this->resource->provider_signature : null,
            "provider_signature" => $this->resource->provider_signature ? $this->resource->provider_signature : null,

            "provider_name" => $this->resource->provider_name,
            "provider_id" => $this->resource->provider_id,
            "supervisor_id" => $this->resource->supervisor_id,
            'tecnico' => $this->resource-> tecnico,
            // 'tecnico' => [
            //     // 'id'=> $this->resource->tecnico->provider_name,
            //     'name' => $this->resource->tecnico->name,
            //     'surname' => $this->resource->tecnico->surname,
            //     'npi' => $this->resource->tecnico->npi,
            // ],
            // "supervisor_signature"=> $this->resource->supervisor_signature ? env("APP_URL")."storage/".$this->resource->supervisor_signature : null,
            // "supervisor_signature"=> $this->resource->supervisor_signature ? env("APP_URL").$this->resource->supervisor_signature : null,
            "supervisor_signature" => $this->resource->supervisor_signature ? $this->resource->supervisor_signature : null,
            "supervisor_name" => $this->resource->supervisor_name,
            'supervisor' => $this->resource-> supervisor,
            // 'supervisor' => [
            //     // 'id'=> $this->resource->supervisor->supervisor_name,
            //     'name' => $this->resource->supervisor->name,
            //     'surname' => $this->resource->supervisor->surname,
            //     'npi' => $this->resource->supervisor->npi,
            // ],

            "billedbcba" => $this->resource->billedbcba,
            "billed" => $this->resource->billed,
            "paid" => $this->resource->paid,
            "md" => $this->resource->md,
            "md2" => $this->resource->md2,
            "md3" => $this->resource->md3,
            "meet_with_client_at" => $this->resource->meet_with_client_at,
            "provider" => $this->resource->provider,
            "insuranceId" => $this->resource->insuranceId,

            "status" => $this->resource->status,
            "location_id" => $this->resource->location_id,

            "session_date" => $this->resource->session_date ? Carbon::parse($this->resource->session_date)->format("Y-m-d") : null,
            "participants" => $this->resource->participants,
            "pos" => $this->resource->pos,
            "time_in" => $this->resource->time_in ? Carbon::parse($this->resource->time_in)->format(" H:i:s") : null,
            "time_out" => $this->resource->time_out ? Carbon::parse($this->resource->time_out)->format(" H:i:s") : null,
            "time_in2" => $this->resource->time_in2 ? Carbon::parse($this->resource->time_in2)->format(" H:i:s") : null,
            "time_out2" => $this->resource->time_out2 ? Carbon::parse($this->resource->time_out2)->format(" H:i:s") : null,
            // al obtener las horas trabajadas se suman
            //convertimos las horas para poder sumarlas
            //sumamos la hora de inicio con la hora final y le restamos los minutos de descanso.
            "session_length_morning_total" => date("H:i", strtotime($this->resource->time_out) - strtotime($this->resource->time_in)),
            "session_length_afternon_total" => date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2)),

            "total_hours" =>
            date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2) + strtotime($this->resource->time_out) - strtotime($this->resource->time_in)),
            "session_length_total" =>
            date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2) + strtotime($this->resource->time_out) - strtotime($this->resource->time_in)),

            "total_minutes" => $this->resource->total_minutes,
            "total_units" => $this->resource->total_units,

            "modifications_needed_at_this_time" => $this->resource->modifications_needed_at_this_time,
            "additional_goals_or_interventions" => $this->resource->additional_goals_or_interventions,
            "cargiver_participation" => $this->resource->cargiver_participation,
            "was_the_client_present" => $this->resource->was_the_client_present,
            "asked_and_clarified_questions_about_the_implementation_of" => $this->resource->asked_and_clarified_questions_about_the_implementation_of,
            "reinforced_caregiver_strengths_in" => $this->resource->reinforced_caregiver_strengths_in,
            "gave_constructive_feedback_on" => $this->resource->gave_constructive_feedback_on,
            "recomended_more_practice_on" => $this->resource->recomended_more_practice_on,
            "type" => $this->resource->type,
            "environmental_changes" => $this->resource->environmental_changes,
            "BCBA_conducted_client_observations" => $this->resource->BCBA_conducted_client_observations,
            "BCBA_conducted_assessments" => $this->resource->BCBA_conducted_assessments,

            "interventions" => is_string($this->resource->interventions)
                ? json_decode($this->resource->interventions) : $this->resource->interventions,

            "interventions2" => is_string($this->resource->interventions2)
            ? json_decode($this->resource->interventions2) : $this->resource->interventions2,

            "behaviors" => is_string($this->resource->behaviors)
            ? json_decode($this->resource->behaviors) : $this->resource->behaviors,

            "intake_outcome" => is_string($this->resource->intake_outcome)
            ? json_decode($this->resource->intake_outcome) : $this->resource->intake_outcome,

            "newlist_added" => is_string($this->resource->newlist_added)
            ? json_decode($this->resource->newlist_added) : $this->resource->newlist_added,

            "replacements" => is_string($this->resource->replacements)
            ? json_decode($this->resource->replacements) : $this->resource->replacements,
            "replacements2" => is_string($this->resource->replacements2)
            ? json_decode($this->resource->replacements2) : $this->resource->replacements2,


            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : null,
            "updated_at" => $this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->format("Y-m-d h:i A") : null,

        ];
    }
}
