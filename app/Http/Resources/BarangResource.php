<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
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
            'kelompok_kegiatan_id' => $this->kelompok_kegiatan_id,
            'kelompok_barang_id' => $this->kelompok_barang_id,
            'satuan_id' => $this->satuan_id,
            'nama' => $this->nama,
            'nama_satuan' => $this->nama_satuan,
            'nama_kelompok_kegiatan' => $this->nama_kelompok_kegiatan,
            'nama_kelompok_barang' => $this->nama_kelompok_barang,
        ];
    }
}
