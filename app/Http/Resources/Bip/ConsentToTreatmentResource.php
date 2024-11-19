<?php

namespace App\Http\Resources\Bip;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsentToTreatmentResource extends JsonResource
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
            // "id"=>$this->resource->id,
            "patient_id" => $this->resource->patient_id,
            "client_id" => $this->resource->client_id,
            "bip_id" => $this->resource->bip_id,
            "analyst_signature" => $this->resource->analyst_signature ? env("APP_URL") . "storage/" . $this->resource->analyst_signature : null,
            // "analyst_signature"=> $this->resource->analyst_signature ? env("APP_URL").$this->resource->analyst_signature : null,
            "parent_guardian_signature" => $this->resource->parent_guardian_signature ? env("APP_URL") . "storage/" . $this->resource->parent_guardian_signature : null,
            // "parent_guardian_signature"=> $this->resource->parent_guardian_signature ? env("APP_URL").$this->resource->parent_guardian_signature : null,
            "analyst_signature_date" => $this->resource->analyst_signature_date ? Carbon::parse($this->resource->analyst_signature_date)->format("d/m/Y") : null,
            "parent_guardian_signature_date" =>
            $this->resource->parent_guardian_signature_date ? Carbon::parse($this->resource->parent_guardian_signature_date)->format("d/m/Y") : null,
            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : null,
        ];
    }
}
