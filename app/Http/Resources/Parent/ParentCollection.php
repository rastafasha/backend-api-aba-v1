<?php

namespace App\Http\Resources\Parent;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParentCollection extends ResourceCollection
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
            "data" => ParentResource::collection($this->collection)
        ];
    }
}
