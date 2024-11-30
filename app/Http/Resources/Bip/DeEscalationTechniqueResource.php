<?php

namespace App\Http\Resources\Bip;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DeEscalationTechniqueResource extends JsonResource
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
            "client_id" => $this->resource->client_id,
            "bip_id" => $this->resource->bip_id,
            "recomendation_lists" =>
            is_string($this->resource->recomendation_lists)
                ? json_decode($this->resource->recomendation_lists) : $this->resource->family_envolment->caregivers_training_goals,

            // "recomendation_lists" => json_decode($this->resource->recomendation_lists) ? : null,
            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : null,

        ];
    }
}
