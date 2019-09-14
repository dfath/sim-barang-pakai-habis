<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KelompokBarangResource extends JsonResource
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
            'nama' => $this->nama,
            'nama_kelompok_kegiatan' => $this->nama_kelompok_kegiatan,
        ];
    }
}
