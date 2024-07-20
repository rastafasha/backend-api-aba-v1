<?php

namespace App\Http\Resources\Billing\ClientReport;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientReportResource extends JsonResource
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
            'md'=>$this->resource->md,
            'md2'=>$this->resource->md2,
            'billed'=>$this->resource->billed,
            'pay'=>$this->resource->pay,
            'pos'=>$this->resource->pos,
            'pa_number'=>$this->resource->pa_number,
            'insurer_id'=>$this->resource->insurer_id,
            'cpt_code'=>$this->resource->cpt_code,
            'charges'=>$this->resource->charges,
            //viene de la session_date de la notarbt
            'session_date'=>$this->resource->session_date,
            'npi'=>$this->resource->npi,
            
            "total_hours" =>$this->resource->total_hours ? Carbon::parse($this->resource->total_hours)->format(" H:i:s") : NULL,
            //totales de unidades
            'total_units'=>$this->resource->total_units, 
           
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,            

        ];
    }
}
