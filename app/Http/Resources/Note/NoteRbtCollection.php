<?php

namespace App\Http\Resources\Note;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NoteRbtCollection extends ResourceCollection
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
            "data" => NoteRbtResource::collection($this->collection),

        ];
    }
}
