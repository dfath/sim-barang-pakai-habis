<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelompokBarang extends Model
{
    protected $table = 'kelompok_barang';

    protected $fillable = [
        'kelompok_kegiatan_id',
        'nama'
    ];
}
