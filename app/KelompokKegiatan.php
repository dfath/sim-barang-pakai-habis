<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelompokKegiatan extends Model
{
    protected $table = 'kelompok_kegiatan';

    protected $fillable = [
        'nama'
    ];
}
