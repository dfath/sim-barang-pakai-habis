<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangKeluarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'barang_id' => $this->barang_id,
            'unit_kerja_id' => $this->unit_kerja_id,
            'volume' => $this->volume,
            'tanggal' => $this->tanggal
        ];
    }
}
