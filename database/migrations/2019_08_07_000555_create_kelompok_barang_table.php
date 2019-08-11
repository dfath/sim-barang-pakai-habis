<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelompokBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kelompok_kegiatan_id');
            $table->foreign('kelompok_kegiatan_id')->references('id')->on('kelompok_kegiatan');
            $table->string('nama');
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
        Schema::dropIfExists('kelompok_barang');
    }
}
