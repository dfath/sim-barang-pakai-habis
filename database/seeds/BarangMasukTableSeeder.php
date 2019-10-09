<?php

use Illuminate\Database\Seeder;

class BarangMasukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenisBukti = ['nota', 'bon'];

        $k=1;
        for ($i=1; $i <= 200; $i++) {
            DB::table('barang_masuk')->insert([
                'id' => $i,
                'kelompok_kegiatan_id' => 7,
                'kelompok_barang_id' => 1,
                'perusahaan_id' => rand(1, 5),
                'tahun_anggaran' => 2019,
                'tanggal_perolehan' => date("Y-m-d", mktime(0, 0, 0, rand(1, date('n')), rand(1, date('j')), 2019)),
                'jenis_bukti' => $jenisBukti[rand(0,1)],
                'bukti_transaksi' => Str::random(10),
            ]);
            for ($j=1; $j <= 1; $j++) {
                DB::table('barang_masuk_detil')->insert([
                    'barang_masuk_id' => $i,
                    'volume_dpa_id' => ($i + $j) % 179 + 1,
                    'volume' => rand(8, 16),
                ]);
                $k++;
            }
        }
    }
}
