<?php

namespace App\Http\Resources\Bip;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FamilyEnvolmentGoalsCollection extends ResourceCollection
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
            "data" => FamilyEnvolmentGoalsResource::collection($this->collection)
        ];
    }
}
