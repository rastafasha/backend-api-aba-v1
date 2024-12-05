<?php

namespace App\Http\Resources\Billing\ClientReport;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientReportResource extends JsonResource
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
            // traemos al paciente
            'patient_identifier' => $this->resource->patient_identifier,

              // traemos al especialista
            'sponsor_id' => $this->resource->sponsor_id,
            'note_rbt_id' => $this->resource->note_rbt_id,
            'note_bcba_id' => $this->resource->note_bcba_id,
            'insurer_id' => $this->resource->insurer_id,
            'md' => $this->resource->md,
            'md2' => $this->resource->md2,
            'md3' => $this->resource->md3,
            'mdbcba' => $this->resource->mdbcba,
            'md2bcba' => $this->resource->md2bcba,
            'billed' => $this->resource->billed,
            'billedbcba' => $this->resource->billedbcba,
            'pay' => $this->resource->pay,
            'paybcba' => $this->resource->paybcba,
            'pos' => $this->resource->pos,
            'pa_number' => $this->resource->pa_number,
            'cpt_code' => $this->resource->cpt_code,
            'chargesrbt' => $this->resource->chargesrbt,
            'chargesbcba' => $this->resource->chargesbcba,
            //viene de la session_date de la notarbt
            'session_date' => $this->resource->session_date,
            'npi' => $this->resource->npi,

            "total_hours" => $this->resource->total_hours ? Carbon::parse($this->resource->total_hours)->format(" H:i:s") : null,
            //totales de unidades
            'total_units' => $this->resource->total_units,

            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : null,

        ];
    }
}
