<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VolumeDpaResource extends JsonResource
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
            'tahun_anggaran' => $this->tahun_anggaran,
            'volume' => $this->volume,
            'harga_satuan' => $this->harga_satuan,
            'nama_barang' => $this->nama_barang,
            'nama_kelompok_kegiatan' => $this->nama_kelompok_kegiatan,
            'nama_kelompok_barang' => $this->nama_kelompok_barang,
        ];
    }
}
