<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstansiResource extends JsonResource
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
            'nama_aplikasi' => $this->nama_aplikasi,
            'nama_instansi' => $this->nama_instansi,
            'alamat_instansi' => $this->alamat_instansi,
            'kepala_opd' => $this->kepala_opd,
            'pengelola' => $this->pengelola
        ];
    }
}
