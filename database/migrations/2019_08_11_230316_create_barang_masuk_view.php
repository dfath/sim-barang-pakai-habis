<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangMasukView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW barang_masuk_detil_view AS
        (
            SELECT
                bmd.id,
                bmd.barang_masuk_id,
                bmd.volume_dpa_id,
                bm.bukti_transaksi,
                bm.jenis_bukti,
                bm.tahun_anggaran,
                bm.tanggal_perolehan,
                bm.kelompok_barang_id,
                bm.kelompok_kegiatan_id,
                bm.perusahaan_id,
                bmd.volume,
                vd.harga_satuan,
                vd.barang_id,
                vd.volume as volume_dpa,
                (bmd.volume * vd.harga_satuan) AS total,
                p.nama AS nama_perusahaan,
                b.nama AS nama_barang,
                kb.nama AS nama_kelompok_barang,
                kk.nama AS nama_kelompok_kegiatan
            FROM barang_masuk_detil bmd
                LEFT JOIN barang_masuk bm ON bmd.barang_masuk_id = bm.id
                LEFT JOIN volume_dpa vd ON bmd.volume_dpa_id = vd.id
                LEFT JOIN perusahaan p ON bm.perusahaan_id = p.id
                LEFT JOIN barang b ON vd.barang_id = b.id
                LEFT JOIN kelompok_barang kb ON bm.kelompok_barang_id = kb.id
                LEFT JOIN kelompok_kegiatan kk ON bm.kelompok_kegiatan_id = kk.id
        )
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW barang_masuk_detil_view');
    }
}
