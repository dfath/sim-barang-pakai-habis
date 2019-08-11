<?php

use Illuminate\Database\Seeder;

class KelompokBarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kelompok_barang')->insert([
            'id' => 1,
            'kelompok_kegiatan_id' => 7,
            'nama' => 'Belanja Alat Tulis Kantor',
        ]);
        DB::table('kelompok_barang')->insert([
            'id' => 2,
            'kelompok_kegiatan_id' => 7,
            'nama' => 'Belanja Perangko, materai dan benda pos lainnya',
        ]);
        DB::table('kelompok_barang')->insert([
            'id' => 3,
            'kelompok_kegiatan_id' => 7,
            'nama' => 'Belanja pakai habis perlengkapan komputer dan printer',
        ]);
    }
}
