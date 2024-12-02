<?php

namespace App\Http\Resources\Parent;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            // 'patient'=>$this->resource-> patient,
            //     'patient'=>[
            //         'patient_id'=> $this->resource->patient->patient_id,
            //         "first_name"=>$this->resource->patient->first_name,
            //         "last_name"=>$this->resource->patient->last_name,
            //         "full_name"=> $this->resource->patient->first_name.' '.$this->resource->patient->last_name,
            //         "email"=>$this->resource->patient->email,
            //     ],
             "location_id" => $this->resource->location_id,
            "name" => $this->resource->name,
            "surname" => $this->resource->surname,
            "full_name" => $this->resource->name . ' ' . $this->resource->surname,
            "email" => $this->resource->email,
            "password" => $this->resource->password,
            // "rolename"=>$this->resource->rolename,
            "phone" => $this->resource->phone,
            "birth_date" => $this->resource->birth_date ? Carbon::parse($this->resource->birth_date)->format("Y/m/d") : null,
            "gender" => $this->resource->gender,
            "address" => $this->resource->address,
            "status" => $this->resource->status,
            // "avatar" => $this->resource->avatar ? env("APP_URL") . "storage/" . $this->resource->avatar : null,
            "avatar" => $this->resource->avatar ? env("APP_URL") . $this->resource->avatar : null,
            "roles" => $this->resource->roles->first(),

            "documents_pending" => json_decode($this->resource->documents_pending),

            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y/m/d") : null,

        ];
    }
}
