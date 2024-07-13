<?php

namespace App\Http\Resources\Insurance;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InsuranceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data"=> InsuranceResource::collection($this->collection)
        ];
    }
}
