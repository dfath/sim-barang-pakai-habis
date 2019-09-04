<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

    protected $fillable = [
        'kelompok_kegiatan_id',
        'kelompok_barang_id',
        'perusahaan_id',
        'tahun_anggaran',
        'tanggal_perolehan',
        'jenis_bukti',
        'bukti_transaksi'
    ];
}
