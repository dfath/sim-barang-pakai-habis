<?php

use Illuminate\Database\Seeder;

class KelompokKegiatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kelompok_kegiatan')->insert([
            'id' => 1,
            'nama' => 'Penyediaan jasa surat menyurat',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 2,
            'nama' => 'Penyediaan jasa komunikasi, sumber daya air dan listrik',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 3,
            'nama' => 'Penyediaan jasa peralatan dan perlengkapan kantor',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 4,
            'nama' => 'Penyediaan jasa pemeliharaan dan perizinan kendaraan dinas/operasional',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 5,
            'nama' => 'Penyediaan jasa administrasi keuangan',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 6,
            'nama' => 'Penyediaan jasa kebersihan dan keamanan kantor',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 7,
            'nama' => 'Penyediaan alat tulis kantor',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 8,
            'nama' => 'Penyediaan barang cetakan dan penggandaan',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 9,
            'nama' => 'Penyediaan bahan bacaan dan peraturan perundang-undangan',
        ]);
        DB::table('kelompok_kegiatan')->insert([
            'id' => 10,
            'nama' => 'enyediaan makanan dan minuman',
        ]);
    }
}
