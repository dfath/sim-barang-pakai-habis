<?php

use Illuminate\Database\Seeder;

class BarangTableSeeder extends Seeder
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
                DB::table('barang')->insert([
                    'id' => $row,
                    'nama' => $data[0],
                    'satuan_id' => $data[1],
                    'kelompok_kegiatan_id' => 7,
                    'kelompok_barang_id' => 1,
                ]);
            }
            fclose($handle);
        }
    }
}
