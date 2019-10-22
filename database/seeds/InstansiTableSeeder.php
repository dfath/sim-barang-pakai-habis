<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('instansi')->insert([
            'id' => 1,
            'nama_aplikasi' => 'Sistem Informasi Manajemen Barang Pakai Habis',
            'nama_instansi' => 'Pemerintah Daerah Kabupaten Lebak',
            'alamat_instansi' => 'Jalan Abdi Negara No. 3. Rangkasbitung, Kabupaten Lebak, Provinsi Banten',
            'kepala_opd' => 'Suparman',
            'pengelola' => 'Suwandi',
        ]);
    }
}
