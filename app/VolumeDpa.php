<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VolumeDpa extends Model
{
    protected $table = 'volume_dpa';

    protected $fillable = [
        'barang_id',
        'tahun_anggaran',
        'volume',
        'harga_satuan'
    ];
}
