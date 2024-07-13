<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->resource-> id,
            'patient_id'=>$this->resource->patient_id,
            'name_file'=> $this->resource->name_file,
                    'size'=> $this->resource->size,
                    'resolution'=> $this->resource->resolution,
                    'file'=> env("APP_URL")."storage/".$this->resource->file,
                    // 'file'=> env("APP_URL").$this->resource->file,
                    'type'=> $this->resource->type,
            // 'files'=>$this->resource->files->map(function($file){
            //     return [
            //         'id'=> $file->id,
            //         'name_file'=> $file->name_file,
            //         'size'=> $file->size,
            //         'resolution'=> $file->resolution,
            //         'file'=> env("APP_URL")."storage/".$file->file,
            //         // 'file'=> env("APP_URL").$file->file,
            //         'type'=> $file->type,
            //     ];
            // })
        ];
    }
}
