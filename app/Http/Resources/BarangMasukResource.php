<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangMasukResource extends JsonResource
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
            'perusahaan_id' => $this->perusahaan_id,
            'tahun_anggaran' => $this->tahun_anggaran,
            'tanggal_perolehan' => $this->tanggal_perolehan,
            'jenis_bukti' => $this->jenis_bukti,
            'bukti_tansaksi' => $this->bukti_tansaksi,
        ];
    }
}
