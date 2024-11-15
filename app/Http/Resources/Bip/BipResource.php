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
            "id"=>$this->resource->id,
            "type_of_assessment"=>$this->resource->type_of_assessment,
            
            // "patientID"=>$this->resource->patientID,
            
            "doctor_id" =>$this->resource->doctor_id,
            "doctor" =>$this->resource->doctor ? 
                [
                    "id" =>$this->resource->doctor->id,
                    "full_name" =>$this->resource->doctor->name.' '.$this->resource->doctor->surname,
                    "avatar"=> $this->resource->doctor->avatar ? env("APP_URL")."storage/".$this->resource->doctor->avatar : null,
                    // "avatar"=> $this->resource->doctor->avatar ? env("APP_URL").$this->resource->doctor->avatar : null,
                    
                ]: NULL,
            "patient_id"=>$this->resource->patient_id,
            // "patient" =>$this->resource->patient ? 
            //     [
            //         "patient_id" =>$this->resource->patient->patient_id,
            //         "full_name" =>$this->resource->patient->first_name.' '.$this->resource->patient->last_name,
            //         "avatar"=> $this->resource->patient->avatar ? env("APP_URL")."storage/".$this->resource->patient->avatar : null,
            //         // "avatar"=> $this->resource->doctor->avatar ? env("APP_URL").$this->resource->patient->avatar : null,
                    
            //     ]: NULL,
            "background_information"=>$this->resource->background_information,
            "previus_treatment_and_result"=>$this->resource->previus_treatment_and_result,
            "current_treatment_and_progress"=>$this->resource->current_treatment_and_progress,
            "education_status"=>$this->resource->education_status,
            "phisical_and_medical_status"=>$this->resource->phisical_and_medical_status,
            "assestment_conducted"=>$this->resource->assestment_conducted,
            "strengths"=>$this->resource->strengths,
            "weakneses"=>$this->resource->weakneses,
            
            'documents_reviewed'=>$this->resource->documents_reviewed,
            'maladaptives'=> json_decode($this->resource-> maladaptives),
            "assestment_conducted_options"=>json_decode($this->resource-> assestment_conducted_options),
            "assestmentEvaluationSettings"=>json_decode($this->resource-> assestmentEvaluationSettings),
            "prevalent_setting_event_and_atecedents"=>json_decode($this->resource-> prevalent_setting_event_and_atecedents),
            "interventions"=>json_decode($this->resource-> interventions),
            "goal_stos"=>json_decode($this->resource->goal_stos),
            "goal_ltos"=>json_decode($this->resource->goal_ltos),
            
            
            "hypothesis_based_intervention"=>$this->resource->hypothesis_based_intervention ,
            
            "tangibles"=>json_decode($this->resource->tangibles),
            "attention"=>json_decode($this->resource->attention),
            "escape"=>json_decode($this->resource->escape),
            "sensory"=>json_decode($this->resource->sensory),
            
            "phiysical_and_medical"=>$this->resource->phiysical_and_medical,
            "phiysical_and_medical_status"=>json_decode($this->resource->phiysical_and_medical_status),

            "reduction_goal"=>$this->resource->reduction_goals ,
            "sustitution_goal"=>$this->resource->sustitution_goals , 
                
            "family_envolment"=>$this->resource->family_envolments ,
            "monitoring_evalutating"=>$this->resource->monitoring_evalutatings ,
            "generalization_training"=>$this->resource->generalization_trainings ,
            "crisis_plan"=>$this->resource->crisis_plans ,
            "de_escalation_technique"=>$this->resource->de_escalation_techniques ,
            "consent_to_treatment"=>$this->resource->consent_to_treatments,
            // 'consent_to_treatment'=>$this->resource-> consent_to_treatments,
            //     'consent_to_treatment'=>[
            //         // 'id'=> $this->resource->clin_director->clin_director_id,
            //         'bip_id'=> $this->resource->consent_to_treatments->bip_id,
            //         'patient_id'=> $this->resource->consent_to_treatments->patient_id,
            //         'client_id'=> $this->resource->consent_to_treatments->client_id,
            //         'analyst_signature'=> $this->resource->consent_to_treatments->analyst_signature,
            //         'analyst_signature_date'=> $this->resource->consent_to_treatments->analyst_signature_date,
            //         'parent_guardian_signature'=> $this->resource->consent_to_treatments->parent_guardian_signature,
            //         'parent_guardian_signature_date'=> $this->resource->consent_to_treatments->parent_guardian_signature_date,
            //         'created_at'=> $this->resource->consent_to_treatments->created_at,
            //         'updated_at'=> $this->resource->consent_to_treatments->updated_at,
            //     ],
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d") : NULL,            

        ];
    }
}
