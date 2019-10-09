<?php

namespace App\Repositories;

use DB;
use App\BarangKeluar;

/**
 * Barang Keluar
 */
class BarangKeluarRepository
{

    /**
     * hitung aggregates total barang keluar
     *
     * @param int $barang_id
     * @param string $tanggal_mulai
     * @param string $tanggal_selesai
     * @return object
     */
    public function volumeBarangKeluarPerTanggal($barang_id, $tanggal_mulai, $tanggal_selesai)
    {
        $query = DB::table('barang_keluar');
        $query->select(DB::raw('COALESCE( SUM(volume), 0) as total_volume'));
        $query->whereRaw('barang_id = ?', [$barang_id]);
        $query->whereRaw('tanggal >= ?', [$tanggal_mulai]);
        $query->whereRaw('tanggal <= ?', [$tanggal_selesai]);

        return $query->first();
    }

}
