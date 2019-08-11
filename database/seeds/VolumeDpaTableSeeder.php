<?php

use Illuminate\Database\Seeder;

class VolumeDpaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = 0;
        if (($handle = fopen( __DIR__ . "/barang.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                DB::table('volume_dpa')->insert([
                    'id' => $row,
                    'barang_id' => $row,
                    'tahun_anggaran' => 2019,
                    'volume' => rand(5,50),
                    'harga_satuan' => $data[2],
                ]);
            }
            fclose($handle);
        }
    }
}
