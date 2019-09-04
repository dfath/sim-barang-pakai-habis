<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/barang_masuk', 'Api\BarangMasukController');

    Route::apiResource('/barang_masuk_detil', 'Api\BarangMasukDetilController');

    Route::apiResource('/barang_keluar', 'Api\BarangKeluarController');

    Route::apiResource('/kelompok_kegiatan', 'Api\KelompokKegiatanController');

    Route::apiResource('/kelompok_barang', 'Api\KelompokBarangController');

    // Route::apiResource('/barang', 'Api\BarangController');

    Route::apiResource('/satuan', 'Api\SatuanController');

    Route::apiResource('/unit_kerja', 'Api\UnitKerjaController');

    Route::apiResource('/instansi', 'Api\InstansiController')->only([
        'show', 'update'
    ]);

});


