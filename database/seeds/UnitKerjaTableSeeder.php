<?php

use Illuminate\Database\Seeder;

class UnitKerjaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_kerja')->insert([
            'id' => 1,
            'nama' => 'Bagian Keuangan',
        ]);
        DB::table('unit_kerja')->insert([
            'id' => 2,
            'nama' => 'Bagian Humas',
        ]);
        DB::table('unit_kerja')->insert([
            'id' => 3,
            'nama' => 'Bagian Kesejahteraan Rakyat',
        ]);
        DB::table('unit_kerja')->insert([
            'id' => 4,
            'nama' => 'Bagian Pemerintahan',
        ]);
        DB::table('unit_kerja')->insert([
            'id' => 5,
            'nama' => 'Bagian Umum',
        ]);
    }
}
