<?php

namespace App\Http\Resources\Patient;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            "patient_identifier" => $this->resource->patient_identifier,// en este caso el patient_id es ingresado manualmente ... // para la relacion con el id es client_id
            "first_name" => $this->resource->first_name,
            "last_name" => $this->resource->last_name,
            "full_name" => $this->resource->first_name . ' ' . $this->resource->last_name,
            "email" => $this->resource->email,
            "phone" => $this->resource->phone,
            // "avatar" => $this->resource->avatar ? env("APP_URL") . "storage/" . $this->resource->avatar : null,
            "avatar" => $this->resource->avatar ? env("APP_URL") . $this->resource->avatar : null,
            "birth_date" => $this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y/m/d") : null,
            "gender" => $this->resource->gender,
            "address" => $this->resource->address,
            "language" => $this->resource->language,
            "home_phone" => $this->resource->home_phone,
            "work_phone" => $this->resource->work_phone,
            "zip" => $this->resource->zip,
            "city" => $this->resource->city,
            "relationship" => $this->resource->relationship,
            "profession" => $this->resource->profession,
            "education" => $this->resource->education,
            "state" => $this->resource->state,
            "school_name" => $this->resource->school_name,
            "school_number" => $this->resource->school_number,
            "age" => $this->resource->age,
            "parent_guardian_name" => $this->resource->parent_guardian_name,
            "schedule" => $this->resource->schedule,
            "summer_schedule" => $this->resource->summer_schedule,
            "diagnosis_code" => $this->resource->diagnosis_code,
            "special_note" => $this->resource->special_note,

            "patient_control" => $this->resource->patient_control,

            "status" => $this->resource->status,

            //benefits
            // "insuranceId" => $this->resource->insuranceId,
            "insurer_id" => $this->resource->insurer_id,
            "insurance_identifier" => $this->resource->insurance_identifier,
            // "insurer_secundary" => $this->resource->insurer_secundary,
            "insurer_secondary_id" => $this->resource->insurer_secondary_id,
            "insurance_secondary_identifier" => $this->resource->insurance_secondary_identifier,



            'insurances' => $this->resource->insurances,
                'insurances' => [
                    // 'id'=> $this->resource->insurances->insurer_id,
                    'name' => $this->resource->insurances->name,
                    'notes' => $this->resource->insurances-> notes ? : null,
                    'services' => $this->resource->insurances-> services ? : null,
                ],

            "location_id" => $this->resource->location_id,
                    'locals' => [
                        // 'id'=> $this->resource->clinic->location_id,
                        'title' => $this->resource->locals->title,
                        "address" => $this->resource->locals->address,
                        "phone1" => $this->resource->locals->phone1,
                        "phone2" => $this->resource->locals->phone2,
                        "email" => $this->resource->locals->email,
                        "city" => $this->resource->locals->city,
                        "state" => $this->resource->locals->state,
                        "zip" => $this->resource->locals->zip,
                    ],





            "elegibility_date" => $this->resource->elegibility_date ? Carbon::parse($this->resource->elegibility_date)->format("Y/m/d") : null,

            "pos_covered" => $this->resource->pos_covered ,

            "deductible_individual_I_F" => $this->resource->deductible_individual_I_F,
            "balance" => $this->resource->balance,
            "coinsurance" => $this->resource->coinsurance,
            "copayments" => $this->resource->copayments,
            "oop" => $this->resource->oop,

            //intake
            "welcome" => $this->resource->welcome,
            "consent" => $this->resource->consent,
            "insurance_card" => $this->resource->insurance_card,
            "eligibility" => $this->resource->eligibility,
            "mnl" => $this->resource->mnl,
            "referral" => $this->resource->referral,
            "ados" => $this->resource->ados,
            "iep" => $this->resource->iep,
            "asd_diagnosis" => $this->resource->asd_diagnosis,
            "cde" => $this->resource->cde,
            "submitted" => $this->resource->submitted,
            "interview" => $this->resource->interview,
            "eqhlid" => $this->resource->eqhlid,
            "telehealth" => $this->resource->telehealth,
            "pay" => $this->resource->pay,

            //pas
            // "pa_assessments" => $this->resource->pa_assessments ? : null,
            // "pa_services"=>$this->resource->paServices,

            "rbt_home_id" => $this->resource->rbt_home_id,
            'rbt_home' => $this->resource-> rbt_home,
                'rbt_home' => [
                    // 'id'=> $this->resource->rbt_home->rbt_home_id,
                    'name' => $this->resource->rbt_home->name,
                    'surname' => $this->resource->rbt_home->surname,
                    'npi' => $this->resource->rbt_home->npi,
                    // "avatar"=> $this->resource->rbt_home->avatar ? env("APP_URL")."storage/".$this->resource->rbt_home->avatar : null,
                    "avatar" => $this->resource->rbt_home->avatar ? env("APP_URL") . $this->resource->rbt_home->avatar : null,
                ],

            "rbt2_school_id" => $this->resource->rbt2_school_id,
                'rbt2_school' => $this->resource->rbt2_school ? [
                    // 'id'=> $this->resource->rbt2_school->rbt2_school_id,
                    'name' => $this->resource->rbt2_school->name ?? null,
                    'surname' => $this->resource->rbt2_school->surname ?? null,
                    'npi' => $this->resource->rbt2_school->npi ?? null,
                    // "avatar"=> $this->resource->rbt2_school->avatar ? env("APP_URL")."storage/".$this->resource->rbt2_school->avatar : null,
                    "avatar" => $this->resource->rbt2_school->avatar ? env("APP_URL") . $this->resource->rbt2_school->avatar : null,
                ] : null,
            "bcba_home_id" => $this->resource->bcba_home_id,
            'bcba_home' => $this->resource-> bcba_home,
                'bcba_home' => [
                    // 'id'=> $this->resource->bcba_home->bcba_home_id,
                    'name' => $this->resource->bcba_home->name,
                    'surname' => $this->resource->bcba_home->surname,
                    'npi' => $this->resource->bcba_home->npi,
                    // "avatar"=> $this->resource->bcba_home->avatar ? env("APP_URL")."storage/".$this->resource->bcba_home->avatar : null,
                    "avatar" => $this->resource->bcba_home->avatar ? env("APP_URL") . $this->resource->bcba_home->avatar : null,
                ],
            "bcba2_school_id" => $this->resource->bcba2_school_id,
                'bcba2_school' => $this->resource->bcba2_school ? [
                    // 'id'=> $this->resource->bcba2_school->bcba2_school_id,
                    'name' => $this->resource->bcba2_school->name,
                    'surname' => $this->resource->bcba2_school->surname,
                    'npi' => $this->resource->bcba2_school->npi,
                    // "avatar"=> $this->resource->bcba2_school->avatar ? env("APP_URL")."storage/".$this->resource->bcba2_school->avatar : null,
                    "avatar" => $this->resource->bcba2_school->avatar ? env("APP_URL") . $this->resource->bcba2_school->avatar : null,
                ] : null,
            "clin_director_id" => $this->resource->clin_director_id,
                'clin_director' => $this->resource->clin_director ? [
                    // 'id'=> $this->resource->clin_director->clin_director_id,
                    'name' => $this->resource->clin_director->name,
                    'surname' => $this->resource->clin_director->surname,
                    'npi' => $this->resource->clin_director->npi,
                    // "avatar"=> $this->resource->clin_director->avatar ? env("APP_URL")."storage/".$this->resource->clin_director->avatar : null,
                    "avatar" => $this->resource->clin_director->avatar ? env("APP_URL") . $this->resource->clin_director->avatar : null,
                ] : null,
            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : null,



        ];
    }
}
