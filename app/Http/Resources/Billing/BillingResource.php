<?php

namespace App\Http\Resources\Billing;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
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
            "id"=>$this->resource->id,
            // traemos al paciente 
            'patient_id'=>$this->resource->patient_id,
            
              // traemos al especialista 
            'sponsor_id'=>$this->resource->sponsor_id,

            //viene de la session_date de la notarbt
            'date'=>$this->resource->date,
            
             //sacamos el total de las horas trabajadas de la nota rbt por nota  
            'total_hours'=>$this->resource->total_hours,

            //totales de unidades
            'total_units'=>$this->resource->total_units, 
            
            'billing_total'=>$this->resource->billing_total,
            'week_total_hours'=>$this->resource->week_total_hours,
            'week_total_units'=>$this->resource->week_total_units ,
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,            

        ];
    }
}
