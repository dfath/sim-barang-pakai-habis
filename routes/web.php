<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/barang-masuk/board', 'BarangMasukController@index')->name('barang-masuk-board');

    Route::get('/unit-kerja/board', 'UnitKerjaController@index')->name('unit-kerja-board');

    Route::get('/satuan/board', 'SatuanController@index')->name('satuan-board');

    Route::get('/kelompok-kegiatan/board', 'KelompokKegiatanController@index')->name('kelompok-kegiatan-board');

    Route::get('/kelompok-barang/board', 'KelompokBarangController@index')->name('kelompok-barang-board');

    Route::get('/barang/board', 'BarangController@index')->name('barang-board');

    Route::get('/perusahaan/board', 'PerusahaanController@index')->name('perusahaan-board');

});
