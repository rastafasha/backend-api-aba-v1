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
        return[
            'id'=>$this->resource-> id,
            "session_date" => $this->resource->session_date ? Carbon::parse($this->resource->session_date)->format("Y-m-d") : NULL,
            // "session_date" => Carbon::parse($this->resource->session_date)->format('d-m-Y'),
            "next_session_is_scheduled_for" => $this->resource->next_session_is_scheduled_for,
            // "next_session_is_scheduled_for" => Carbon::parse($this->resource->next_session_is_scheduled_for)->format('d-m-Y'),
            
            "interventions"=>json_decode($this->resource->interventions) ? : NULL,
            "replacements"=>json_decode($this->resource->replacements) ? : NULL,
            'maladaptives'=> json_decode($this->resource->maladaptives) ? : NULL,

            // 'maladaptives'=>$this->resource->maladaptives->map(function($maladaptive){
            //     return [
            //         "maladaptive_behavior" =>$maladaptive->maladaptive_behavior,
            //         "number_of_occurrences" =>$maladaptive->number_of_occurrences,
                    
            //     ];
            // }),

            // "maladaptives" =>json_decode($this->resource-> maladaptives) ? 
            // [
            //         "maladaptive_behavior" =>$this->resource->maladaptive_behavior,
            //         "number_of_occurrences" =>$this->resource->number_of_occurrences,
                   
                    
                    
            //     ]: NULL,
            
            "bip_id" => $this->resource->bip_id,
            "pos" => $this->resource->pos,
            "environmental_changes" => $this->resource->environmental_changes,
            "provider_credential" => $this->resource->provider_credential,
            
            "patient_id" => $this->resource->patient_id,
            "doctor_id" => $this->resource->doctor_id,
            "meet_with_client_at" =>$this->resource->meet_with_client_at,

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
            // "session_length_total" =>$this->resource->time_out - $this->resource->time_in,
            // "session_length_total2" =>($this->resource->time_out2 - $this->resource->time_in2) /100,
            // "total_hours" => ($this->resource->time_out + $this->resource->time_in + $this->resource->time_out2 + $this->resource->time_in2)/100,
            // // // // "total_units" => ($this->resource->time_out + $this->resource->time_in + $this->resource->time_out2 + $this->resource->time_in2)/100*4,

            "client_appeared" =>$this->resource->client_appeared,
            "as_evidenced_by" =>$this->resource->as_evidenced_by,
            "rbt_modeled_and_demonstrated_to_caregiver" =>$this->resource->rbt_modeled_and_demonstrated_to_caregiver,
            "client_response_to_treatment_this_session" =>$this->resource->client_response_to_treatment_this_session,
            "progress_noted_this_session_compared_to_previous_session" =>$this->resource->progress_noted_this_session_compared_to_previous_session,
            
            
            "provider_signature"=> $this->resource->provider_signature ?  $this->resource->provider_signature : null,
            // "provider_signature"=> $this->resource->provider_signature ? env("APP_URL")."storage/".$this->resource->provider_signature : null,
            // "provider_signature"=> $this->resource->provider_signature ? env("APP_URL").$this->resource->provider_signature : null,
            "provider_name" =>$this->resource->provider_name,

            
            
            "supervisor_signature"=> $this->resource->supervisor_signature ? $this->resource->supervisor_signature : null,
            // "supervisor_signature"=> $this->resource->supervisor_signature ? env("APP_URL")."storage/".$this->resource->supervisor_signature : null,
            // "supervisor_signature"=> $this->resource->supervisor_signature ? env("APP_URL").$this->resource->supervisor_signature : null,
            
            "supervisor_name" =>$this->resource->supervisor_name,
            'supervisor'=>$this->resource-> supervisor,
                'supervisor'=>[
                    'id'=> $this->resource->supervisor->supervisor_name,
                    'name'=> $this->resource->supervisor->name,
                    'surname'=> $this->resource->supervisor->surname,
                    'npi'=> $this->resource->supervisor->npi,
                ],

                
            "provider_name_g" => $this->resource->provider_name_g,
            // 'provider_name_g'=>$this->resource-> provider_name_g,
            //     'tecnicoRbts'=>[
            //         'id'=> $this->resource->tecnicoRbts->id,
            //         'name'=> $this->resource->tecnicoRbts->name,
            //         'surname'=> $this->resource->tecnicoRbts->surname,
            //     ],
            "billed" => $this->resource->billed,
            "pay" => $this->resource->pay,
            "status" => $this->resource->status,
            "md" => $this->resource->md,
            "md2" => $this->resource->md2,
            "cpt_code" => $this->resource->cpt_code,
            "provider" => $this->resource->provider,
            "location_id" => $this->resource->location_id,
            
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            "updated_at"=>$this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->format("Y-m-d h:i A") : NULL,
            
        ];
    }
}
