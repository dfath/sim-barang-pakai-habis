<?php

use Illuminate\Database\Seeder;

class SatuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('satuan')->insert([
            'id' => 1,
            'nama' => 'Pak',
        ]);
        DB::table('satuan')->insert([
            'id' => 2,
            'nama' => 'Dus',
        ]);
        DB::table('satuan')->insert([
            'id' => 3,
            'nama' => 'Buah',
        ]);
        DB::table('satuan')->insert([
            'id' => 4,
            'nama' => 'Kotak',
        ]);
        DB::table('satuan')->insert([
            'id' => 5,
            'nama' => 'Roll',
        ]);
        DB::table('satuan')->insert([
            'id' => 6,
            'nama' => 'Rim',
        ]);
        DB::table('satuan')->insert([
            'id' => 7,
            'nama' => 'Lusin',
        ]);
        DB::table('satuan')->insert([
            'id' => 8,
            'nama' => 'Set',
        ]);
        DB::table('satuan')->insert([
            'id' => 9,
            'nama' => 'Botol',
        ]);
        DB::table('satuan')->insert([
            'id' => 10,
            'nama' => 'Keping',
        ]);
        DB::table('satuan')->insert([
            'id' => 11,
            'nama' => 'Lembar',
        ]);
    }
}
