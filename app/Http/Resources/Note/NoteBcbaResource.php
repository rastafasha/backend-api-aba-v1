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
        return[
            'id'=>$this->resource-> id,
            "bip_id" => $this->resource->bip_id,
            "patient_id" => $this->resource->patient_id,
            "doctor_id" => $this->resource->doctor_id,
            "note_description" => $this->resource->note_description,
            
            "caregiver_goals"=>json_decode($this->resource-> caregiver_goals) ? : null,
            "rbt_training_goals"=>json_decode($this->resource-> rbt_training_goals) ? : null,
            "location" => $this->resource->location,
            
            // "birth_date" => $this->resource->birth_date,
            "birth_date"=>$this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y-m-d") : NULL,
            "aba_supervisor" => $this->resource->aba_supervisor,
            "cpt_code" =>$this->resource->cpt_code,
            "diagnosis_code" =>$this->resource->diagnosis_code,
            
            "rendering_provider" => $this->resource->rendering_provider,
            'rendering'=>$this->resource-> rendering,
                'rendering'=>[
                    // 'id'=> $this->resource->rendering->rendering_provider,
                    'name'=> $this->resource->rendering->name,
                    'surname'=> $this->resource->rendering->surname,
                    'npi'=> $this->resource->rendering->npi,
                ],
            // "provider_signature"=> $this->resource->provider_signature ? env("APP_URL")."storage/".$this->resource->provider_signature : null,
            // "provider_signature"=> $this->resource->provider_signature ? env("APP_URL").$this->resource->provider_signature : null,
            "provider_signature"=> $this->resource->provider_signature ? $this->resource->provider_signature : null,
            "provider_name" =>$this->resource->provider_name,
            'tecnico'=>$this->resource-> tecnico,
                'tecnico'=>[
                    // 'id'=> $this->resource->tecnico->provider_name,
                    'name'=> $this->resource->tecnico->name,
                    'surname'=> $this->resource->tecnico->surname,
                    'npi'=> $this->resource->tecnico->npi,
                ],
            // "supervisor_signature"=> $this->resource->supervisor_signature ? env("APP_URL")."storage/".$this->resource->supervisor_signature : null,
            // "supervisor_signature"=> $this->resource->supervisor_signature ? env("APP_URL").$this->resource->supervisor_signature : null,
            "supervisor_signature"=> $this->resource->supervisor_signature ? $this->resource->supervisor_signature : null,
            "supervisor_name" =>$this->resource->supervisor_name,
            'supervisor'=>$this->resource-> supervisor,
                'supervisor'=>[
                    // 'id'=> $this->resource->supervisor->supervisor_name,
                    'name'=> $this->resource->supervisor->name,
                    'surname'=> $this->resource->supervisor->surname,
                    'npi'=> $this->resource->supervisor->npi,
                ],

                "billedbcba" => $this->resource->billedbcba,
                "paybcba" => $this->resource->paybcba,
                "bcba" => $this->resource->bcba,
                "mdbcba" => $this->resource->mdbcba,
                "md2bcba" => $this->resource->md2bcba,
                "meet_with_client_at" =>$this->resource->meet_with_client_at,
                "provider" => $this->resource->provider,
                "status" => $this->resource->status,
                "location_id" => $this->resource->location_id,
                
                "session_date" => $this->resource->session_date ? Carbon::parse($this->resource->session_date)->format("Y-m-d") : NULL,
                "time_in" =>$this->resource->time_in ? Carbon::parse($this->resource->time_in)->format(" H:i:s") : NULL,
                "time_out" =>$this->resource->time_out ? Carbon::parse($this->resource->time_out)->format(" H:i:s") : NULL,
                "time_in2" =>$this->resource->time_in2 ? Carbon::parse($this->resource->time_in2)->format(" H:i:s") : NULL,
                "time_out2" =>$this->resource->time_out2 ? Carbon::parse($this->resource->time_out2)->format(" H:i:s") : NULL,
                // al obtener las horas trabajadas se suman 
                //convertimos las horas para poder sumarlas
                //sumamos la hora de inicio con la hora final y le restamos los minutos de descanso.
                "session_length_total" => date("H:i", strtotime($this->resource->time_out) - strtotime($this->resource->time_in) ),
                "session_length_total2" => date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2) ),
                "total_hours" => date("H:i", strtotime($this->resource->time_out2) - strtotime($this->resource->time_in2) + strtotime($this->resource->time_out) - strtotime($this->resource->time_in) ),

            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            "updated_at"=>$this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->format("Y-m-d h:i A") : NULL,
            
        ];
    }
}
