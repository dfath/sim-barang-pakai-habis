<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangMasukDetil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuk_detil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('barang_masuk_id');
            $table->unsignedBigInteger('volume_dpa_id');
            $table->foreign('barang_masuk_id')->references('id')->on('barang_masuk');
            $table->foreign('volume_dpa_id')->references('id')->on('volume_dpa');
            $table->integer('volume');
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
        Schema::dropIfExists('barang_masuk_detil');
    }
}
