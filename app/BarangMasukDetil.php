<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasukDetil extends Model
{
    protected $table = 'barang_masuk_detil';

    protected $fillable = [
        'barang_masuk_id',
        'volume_dpa_id',
        'volume'
    ];
}
