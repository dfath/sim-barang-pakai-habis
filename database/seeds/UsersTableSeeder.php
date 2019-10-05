<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin
        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@example.com';
        $admin->password = bcrypt('admin');
        $admin->assignRole('admin');
        $admin->save();

        // pengelola
        $pengelola = new User();
        $pengelola->name = 'pengelola';
        $pengelola->email = 'pengelola@example.com';
        $pengelola->password = bcrypt('pengelola');
        $pengelola->assignRole('pengelola');
        $pengelola->save();

        // kepala
        $kepala = new User();
        $kepala->name = 'kepala';
        $kepala->email = 'kepala@example.com';
        $kepala->password = bcrypt('kepala');
        $kepala->assignRole('kepala');
        $kepala->save();
    }
}
