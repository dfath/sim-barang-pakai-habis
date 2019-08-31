<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansi';

    protected $fillable = [
        'nama_aplikasi',
        'nama_instansi',
        'alamat_instansi',
        'kepala_opd',
        'pengelola'
    ];
}
