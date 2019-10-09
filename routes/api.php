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

    Route::get('/laporan/barang_masuk', 'Api\BarangMasukController@laporan')->name('api-barang-masuk-laporan');

    Route::apiResource('/barang_masuk', 'Api\BarangMasukController');

    Route::apiResource('/barang_masuk_detil', 'Api\BarangMasukDetilController');

    Route::apiResource('/barang_keluar', 'Api\BarangKeluarController');

    Route::get('/laporan/barang_keluar', 'Api\BarangKeluarController@laporan')->name('api-barang-keluar-laporan');

    Route::apiResource('/kelompok_kegiatan', 'Api\KelompokKegiatanController');

    Route::apiResource('/kelompok_barang', 'Api\KelompokBarangController');

    Route::apiResource('/barang', 'Api\BarangController');

    Route::apiResource('/satuan', 'Api\SatuanController');

    Route::apiResource('/perusahaan', 'Api\PerusahaanController');

    Route::apiResource('/unit_kerja', 'Api\UnitKerjaController');

    Route::apiResource('/volume_dpa', 'Api\VolumeDpaController');

    Route::apiResource('/instansi', 'Api\InstansiController')->only([
        'show', 'update'
    ]);

    Route::get('/stok_barang', 'Api\StokBarangController@index');

});


