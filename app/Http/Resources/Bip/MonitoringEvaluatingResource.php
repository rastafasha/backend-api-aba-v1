<?php

namespace App\Http\Resources\Bip;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MonitoringEvaluatingResource extends JsonResource
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
            "rbt_training_goals" =>
            is_string($this->resource->rbt_training_goals)
                ? json_decode($this->resource->rbt_training_goals) : $this->resource->family_envolment->caregivers_training_goals,

            // "rbt_training_goals" => json_decode($this->resource->rbt_training_goals) ? : null,
            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : null,

        ];
    }
}
