<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'barang_id',
        'unit_kerja_id',
        'volume',
        'tanggal'
    ];
}
