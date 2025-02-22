<?php

namespace App\Http\Resources\Bip;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BipResource extends JsonResource
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
            "id" => $this->resource->id,
            "type_of_assessment" => $this->resource->type_of_assessment,
            "doctor_id" => $this->resource->doctor_id,
            "doctor" => $this->resource->doctor ?
                [

                    "id" => $this->resource->doctor->id,
                    "full_name" => $this->resource->doctor->name . ' ' . $this->resource->doctor->surname,
                    // "avatar" => $this->resource->doctor->avatar ? env("APP_URL") . "storage/" . $this->resource->doctor->avatar : null,
                    "avatar" => $this->resource->doctor->avatar ? env("APP_URL") .  $this->resource->doctor->avatar : null,
                ] : null,
            "patient_identifier" => $this->resource->patient_identifier,
            "background_information" => $this->resource->background_information,
            "previous_treatment_and_result" => $this->resource->previous_treatment_and_result,
            "current_treatment_and_progress" => $this->resource->current_treatment_and_progress,
            "education_status" => $this->resource->education_status,
            "phisical_and_medical_status" => $this->resource->phisical_and_medical_status,
            "assestment_conducted" => $this->resource->assestment_conducted,
            "strengths" => $this->resource->strengths,
            "weaknesses" => $this->resource->weaknesses,
            'documents_reviewed' =>
            is_string($this->resource->documents_reviewed)
                ? json_decode($this->resource->documents_reviewed) : $this->resource->documents_reviewed,
            'maladaptives' =>
            is_string($this->resource->maladaptive)
                ? json_decode($this->resource->maladaptives) : $this->resource->maladaptive,
            "assestment_conducted_options" =>
            is_string($this->resource->assestment_conducted_options)
                ? json_decode($this->resource->assestment_conducted_options) : $this->resource->assestment_conducted_options,
            "assestmentEvaluationSettings" =>
            is_string($this->resource->assestmentEvaluationSettings)
                ? json_decode($this->resource->assestmentEvaluationSettings) : $this->resource->assestmentEvaluationSettings,
            "prevalent_setting_event_and_atecedents" =>
            is_string($this->resource->prevalent_setting_event_and_atecedents)
                ? json_decode($this->resource->prevalent_setting_event_and_atecedents) : $this->resource->prevalent_setting_event_and_atecedents,
            "interventions" =>
            is_string($this->resource->interventions)
                ? json_decode($this->resource->interventions) : $this->resource->interventions,
            "goal_stos" =>
            is_string($this->resource->goal_stos)
                ? json_decode($this->resource->goal_stos) : $this->resource->goal_stos,
            "goal_ltos" =>
            is_string($this->resource->goal_ltos)
                ? json_decode($this->resource->goal_ltos) : $this->resource->goal_ltos,
            "hypothesis_based_intervention" => $this->resource->hypothesis_based_intervention,
            "tangibles" =>
            is_string($this->resource->tangibles)
                ? json_decode($this->resource->tangibles) : $this->resource->tangibles,
            "attention" =>
            is_string($this->resource->attention)
                ? json_decode($this->resource->attention) : $this->resource->attention,
            "escape" =>
            is_string($this->resource->escape)
                ? json_decode($this->resource->escape) : $this->resource->escape,
            "sensory" =>
            is_string($this->resource->sensory)
                ? json_decode($this->resource->sensory) : $this->resource->sensory,
            "phiysical_and_medical" => $this->resource->phiysical_and_medical,
            "phiysical_and_medical_status" =>
            is_string($this->resource->phiysical_and_medical_status)
                ? json_decode($this->resource->phiysical_and_medical_status) : $this->resource->phiysical_and_medical_status,

            "reduction_goal" => $this->resource->reduction_goals,
            "sustitution_goal" => $this->resource->sustitution_goals,
            "family_envolment" => $this->resource->family_envolments,

            "monitoring_evalutating" => $this->resource->monitoring_evalutatings,
            "generalization_training" => $this->resource->generalization_trainings,
            "crisis_plan" => $this->resource->crisis_plans,
            "de_escalation_technique" => $this->resource->de_escalation_techniques,
            "consent_to_treatment" => $this->resource->consent_to_treatments,
            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d") : null,

        ];
    }
}
