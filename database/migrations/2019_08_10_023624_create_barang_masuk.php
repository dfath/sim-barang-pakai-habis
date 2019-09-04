<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangMasuk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kelompok_kegiatan_id');
            $table->unsignedInteger('kelompok_barang_id');
            $table->unsignedInteger('perusahaan_id');
            $table->foreign('kelompok_kegiatan_id')->references('id')->on('kelompok_kegiatan');
            $table->foreign('kelompok_barang_id')->references('id')->on('kelompok_barang');
            $table->foreign('perusahaan_id')->references('id')->on('perusahaan');
            $table->year('tahun_anggaran');
            $table->date('tanggal_perolehan');
            $table->enum('jenis_bukti', ['nota', 'bon']);
            $table->string('bukti_transaksi', 50);
            $table->unique('bukti_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }
}
