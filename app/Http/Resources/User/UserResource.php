<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        

        return [
            "id"=>$this->resource->id,
             // "location_id"=>$this->resource->location_id,
            //  "location_id"=>json_decode($this->resource-> location_id),
             "location_id" =>$this->resource->location_id,
                // 'locals'=>$this->resource-> locals,
                //     'locals'=>[
                //         // 'id'=> $this->resource->clinic->location_id,
                //         'title'=> $this->resource->locals->title,
                //         "address"=>$this->resource->locals->address,
                //         "phone1"=>$this->resource->locals->phone1,
                //         "phone2"=>$this->resource->locals->phone2,
                //         "email"=>$this->resource->locals->email,
                //         "city"=>$this->resource->locals->city,
                //         "state"=>$this->resource->locals->state,
                //         "zip"=>$this->resource->locals->zip,
                //     ],
            "name"=>$this->resource->name,
            "surname"=>$this->resource->surname,
            "full_name"=> $this->resource->name.' '.$this->resource->surname,
            "email"=>$this->resource->email,
            "password"=>$this->resource->password,
            // "rolename"=>$this->resource->rolename,
            "phone"=>$this->resource->phone,
            "birth_date"=>$this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y/m/d") : NULL,
            "gender"=>$this->resource->gender,
            "address"=>$this->resource->address,
            "status"=>$this->resource->status,
            "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            "roles"=>$this->resource->roles->first(),
            "currently_pay_through_company"=>$this->resource->currently_pay_through_company,
            "llc"=>$this->resource->llc,
            "ien"=>$this->resource->ien,
            "wc"=>$this->resource->wc,
            "electronic_signature"=>$this->resource->electronic_signature ? env("APP_URL")."storage/".$this->resource->electronic_signature : null,
            // "electronic_signature"=>$this->resource->electronic_signature ? env("APP_URL").$this->resource->electronic_signature : null,
            "agency_location"=>$this->resource->agency_location,
            "city"=>$this->resource->city,
            "languages"=>$this->resource->languages,
            "dob"=>$this->resource->dob,
            "ss_number"=>$this->resource->ss_number,
            "date_of_hire"=>$this->resource->date_of_hire ? Carbon::parse($this->resource->date_of_hire)->format("Y/m/d") : NULL,
            "start_pay"=>$this->resource->start_pay ,
            "driver_license_expiration"=>$this->resource->driver_license_expiration ? Carbon::parse($this->resource->driver_license_expiration)->format("Y/m/d") : NULL,
            "cpr_every_2_years"=>$this->resource->cpr_every_2_years,
            "background_every_5_years"=>$this->resource->background_every_5_years,
            "e_verify"=>$this->resource->e_verify,
            "national_sex_offender_registry"=>$this->resource->national_sex_offender_registry,
            "certificate_number"=>$this->resource->certificate_number,
            "bacb_license_expiration"=>$this->resource->bacb_license_expiration ? Carbon::parse($this->resource->bacb_license_expiration)->format("Y/m/d") : NULL,
            "liability_insurance_annually"=>$this->resource->liability_insurance_annually,
            "local_police_rec_every_5_years"=>$this->resource->local_police_rec_every_5_years,
            "npi"=>$this->resource->npi,
            "medicaid_provider"=>$this->resource->medicaid_provider,
            
            "ceu_hippa_annually"=>$this->resource->ceu_hippa_annually,
            "ceu_domestic_violence_no_expiration"=>$this->resource->ceu_domestic_violence_no_expiration,
            "ceu_security_awareness_annually"=>$this->resource->ceu_security_awareness_annually,
            "ceu_zero_tolerance_every_3_years"=>$this->resource->ceu_zero_tolerance_every_3_years,
            "ceu_hiv_bloodborne_pathogens_infection_control_no_expiration"=>$this->resource->ceu_hiv_bloodborne_pathogens_infection_control_no_expiration,
            "ceu_civil_rights_no_expiration"=>$this->resource->ceu_civil_rights_no_expiration,
            
            "school_badge"=>$this->resource->school_badge,
            "w_9_w_4_form"=>$this->resource->w_9_w_4_form,
            "contract"=>$this->resource->contract,
            "two_four_week_notice_agreement"=>$this->resource->two_four_week_notice_agreement,
            "credentialing_package_bcbas_only"=>$this->resource->credentialing_package_bcbas_only,
            "caqh_bcbas_only"=>$this->resource->caqh_bcbas_only,
            "contract_type"=>$this->resource->contract_type,
            "salary"=>$this->resource->salary,

           
           
           
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y/m/d") : NULL,
            
        ];
    }
}
