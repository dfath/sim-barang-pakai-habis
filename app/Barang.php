<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'kelompok_kegiatan_id',
        'kelompok_barang_id',
        'satuan_id',
        'nama'
    ];
}
