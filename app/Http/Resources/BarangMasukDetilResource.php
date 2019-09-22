<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangMasukDetilResource extends JsonResource
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
            'barang_masuk_id' => $this->barang_masuk_id,
            'volume_dpa_id' => $this->volume_dpa_id,
            'volume' => $this->volume,
            'harga_satuan' => $this->harga_satuan,
            'volume' => $this->volume,
            'total' => $this->total,
            'nama_barang' => $this->nama_barang,
            'volume_dpa' => $this->volume_dpa,
        ];
    }
}
