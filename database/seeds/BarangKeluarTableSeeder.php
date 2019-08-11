<?php

use Illuminate\Database\Seeder;

class BarangKeluarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 200; $i++) {
            DB::table('barang_keluar')->insert([
                'id' => $i,
                'barang_id' => rand(1, 179),
                'unit_kerja_id' => rand(1, 5),
                'volume' => rand(1, 2),
                'tanggal' => date("Y-m-d", mktime(0, 0, 0, rand(1, 12), rand(1, 29), 2019)),
            ]);
        }
    }
}
