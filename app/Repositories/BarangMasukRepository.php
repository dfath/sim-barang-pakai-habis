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
    public function hitungBarangMasukPerTanggal($barang_id, $tahun_anggaran, $tanggal_mulai, $tanggal_selesai)
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
    public function listBarangMasukPerTanggal($tanggal_mulai, $tanggal_selesai)
    {
        $query = DB::table('barang_masuk_detil_view');
        $query->select('barang_id', 'nama_barang', 'tahun_anggaran', 'volume_dpa');
        $query->whereRaw('tanggal_perolehan >= ?', [$tanggal_mulai]);
        $query->whereRaw('tanggal_perolehan <= ?', [$tanggal_selesai]);
        $query->groupBy('barang_id', 'nama_barang', 'tahun_anggaran', 'volume_dpa');

        return $query->get();
    }
}
