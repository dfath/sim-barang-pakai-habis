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
    return redirect(route('login'));
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false
]);

Route::middleware('auth')->group(function () {

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('/role', 'RoleController')->except([
            'create', 'show', 'edit', 'update'
        ]);
        Route::resource('/users', 'UserController')->except([
            'show'
        ]);
        Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
        Route::put('/users/roles/{id}', 'UserController@setRole')->name('users.set_role');
        Route::post('/users/permission', 'UserController@addPermission')->name('users.add_permission');
        Route::get('/users/role-permission', 'UserController@rolePermission')->name('users.roles_permission');
        Route::put('/users/permission/{role}', 'UserController@setRolePermission')->name('users.setRolePermission');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/barang-masuk/board', 'BarangMasukController@index')->name('barang-masuk-board');

    Route::get('/barang-masuk/{id}', 'BarangMasukController@edit')->name('barang-masuk-edit')->where('id', '[0-9]+');

    Route::get('/unit-kerja/board', 'UnitKerjaController@index')->name('unit-kerja-board');

    Route::get('/satuan/board', 'SatuanController@index')->name('satuan-board');

    Route::get('/kelompok-kegiatan/board', 'KelompokKegiatanController@index')->name('kelompok-kegiatan-board');

    Route::get('/kelompok-barang/board', 'KelompokBarangController@index')->name('kelompok-barang-board');

    Route::get('/barang/board', 'BarangController@index')->name('barang-board');

    Route::get('/perusahaan/board', 'PerusahaanController@index')->name('perusahaan-board');

    Route::get('/volume-dpa/board', 'VolumeDpaController@index')->name('volume-dpa-board');

    Route::get('/barang-keluar/board', 'BarangKeluarController@index')->name('barang-keluar-board');

    Route::match(['get', 'post'], '/instansi', 'InstansiController@index')->name('instansi-board');

});
