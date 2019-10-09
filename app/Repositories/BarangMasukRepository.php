<?php

namespace App\Repositories;

use DB;
use App\BarangMasuk;

class BarangMasukRepository
{
    /**
     * hitung aggregates total harga dan total barang
     *
     * @param int $barang_id
     * @param int $tahun_anggaran
     * @param string $tanggal_mulai
     * @param string $tanggal_selesai
     * @return object
     */
    public function volumeDpaPerTanggal($barang_id, $tahun_anggaran, $tanggal_mulai, $tanggal_selesai)
    {
        $query = DB::table('barang_masuk_detil_view');
        $query->select(DB::raw('COALESCE( SUM(volume), 0) as total_volume, COALESCE(SUM(total), 0) as total_harga'));
        $query->whereRaw('barang_id = ?', [$barang_id]);
        $query->whereRaw('tahun_anggaran = ?', [$tahun_anggaran]);
        $query->whereRaw('tanggal_perolehan >= ?', [$tanggal_mulai]);
        $query->whereRaw('tanggal_perolehan <= ?', [$tanggal_selesai]);

        return $query->first();
    }

    /**
     * List barang masuk
     *
     * @param string $tanggal_mulai
     * @param string $tanggal_selesai
     * @return object
     */
    public function volumeBarangMasukPerTanggal($barang_id, $tanggal_mulai, $tanggal_selesai)
    {
        $query = DB::table('barang_masuk_detil_view');
        $query->select('barang_id', 'tahun_anggaran', 'volume_dpa', 'harga_satuan');
        $query->addSelect(DB::raw('COALESCE( SUM(volume), 0) as total_volume, COALESCE(SUM(total), 0) as total_harga'));
        $query->whereRaw('barang_id = ?', [$barang_id]);
        $query->whereRaw('tanggal_perolehan >= ?', [$tanggal_mulai]);
        $query->whereRaw('tanggal_perolehan <= ?', [$tanggal_selesai]);
        $query->groupBy('barang_id', 'tahun_anggaran', 'volume_dpa', 'harga_satuan');
        $query->orderBy('tahun_anggaran');

        return $query->get();
    }
}
