<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kelompok_kegiatan_id');
            $table->unsignedInteger('kelompok_barang_id');
            $table->unsignedInteger('satuan_id');
            $table->foreign('kelompok_kegiatan_id')->references('id')->on('kelompok_kegiatan');
            $table->foreign('kelompok_barang_id')->references('id')->on('kelompok_barang');
            $table->string('nama');
            $table->foreign('satuan_id')->references('id')->on('satuan');
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
        Schema::dropIfExists('barang');
    }
}
