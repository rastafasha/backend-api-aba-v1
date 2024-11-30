<?php

namespace App\Http\Resources\Bip;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CrisisPlanResource extends JsonResource
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
            "patient_identifier" => $this->resource->patient_identifier,
            "bip_id" => $this->resource->bip_id,
            "crisis_description" => $this->resource->crisis_description,
            "crisis_note" => $this->resource->crisis_note,
            "caregiver_requirements_for_prevention_of_crisis" => $this->resource->caregiver_requirements_for_prevention_of_crisis,
            // "risk_factors" => json_decode($this->resource->risk_factors) ? : null,
            // "suicidalities" => json_decode($this->resource->suicidalities) ? : null,
            // "homicidalities" => json_decode($this->resource->homicidalities) ? : null,
            "risk_factors" =>
            is_string($this->resource->risk_factors)
                ? json_decode($this->resource->risk_factors) : $this->resource->family_envolment->caregivers_training_goals,

            "suicidalities" =>
            is_string($this->resource->suicidalities)
                ? json_decode($this->resource->suicidalities) : $this->resource->family_envolment->caregivers_training_goals,

            "homicidalities" =>
            is_string($this->resource->homicidalities)
                ? json_decode($this->resource->homicidalities) : $this->resource->family_envolment->caregivers_training_goals,

            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : null,


        ];
    }
}
