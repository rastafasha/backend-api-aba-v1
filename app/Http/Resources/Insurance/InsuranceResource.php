<?php

namespace App\Http\Resources\Insurance;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InsuranceResource extends JsonResource
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
            "insurer_name"=>$this->resource->insurer_name,
            'services'=> json_decode($this->resource-> services) ? : null,//trae el json convertido para manipular
            'notes'=> json_decode($this->resource-> notes) ? : null,//trae el json convertido para manipular
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            

        ];
    }
}
