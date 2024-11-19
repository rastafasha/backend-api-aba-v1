<?php

namespace App\Http\Resources\Billing\ClientReport;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientReportCollection extends ResourceCollection
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
            "data" => ClientReportResource::collection($this->collection)
        ];
    }
}
