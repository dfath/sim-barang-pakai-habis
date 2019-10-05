<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(InstansiTableSeeder::class);
        $this->call(UnitKerjaTableSeeder::class);
        $this->call(SatuanTableSeeder::class);
        $this->call(KelompokKegiatanTableSeeder::class);
        $this->call(KelompokBarangTableSeeder::class);
        $this->call(BarangTableSeeder::class);
        $this->call(PerusahaanTableSeeder::class);
        $this->call(VolumeDpaTableSeeder::class);
        $this->call(BarangMasukTableSeeder::class);
        $this->call(BarangKeluarTableSeeder::class);
    }
}
