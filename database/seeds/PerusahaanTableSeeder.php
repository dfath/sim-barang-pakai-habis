<?php

use Illuminate\Database\Seeder;

class PerusahaanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perusahaan')->insert([
            'id' => 1,
            'nama' => 'PT Joyko',
        ]);
        DB::table('perusahaan')->insert([
            'id' => 2,
            'nama' => 'PT Kenko',
        ]);
        DB::table('perusahaan')->insert([
            'id' => 3,
            'nama' => 'PT Epson',
        ]);
        DB::table('perusahaan')->insert([
            'id' => 4,
            'nama' => 'PT Canon',
        ]);
        DB::table('perusahaan')->insert([
            'id' => 5,
            'nama' => 'PT Xerox',
        ]);
    }
}
