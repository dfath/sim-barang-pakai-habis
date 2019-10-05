<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // roles
        $roles = [
            ['id'=>1, 'name'=>'admin', 'guard_name'=>'web'],
            ['id'=>2, 'name'=>'pengelola', 'guard_name'=>'web'],
            ['id'=>3, 'name'=>'kepala', 'guard_name'=>'web'],
        ];
        DB::table('roles')->insert($roles);

        // permission
        $permissions = [
            ['id'=>1, 'name'=>'user', 'guard_name'=>'web'],
            ['id'=>2, 'name'=>'instansi', 'guard_name'=>'web'],
            ['id'=>3, 'name'=>'master', 'guard_name'=>'web'],
            ['id'=>4, 'name'=>'barang masuk', 'guard_name'=>'web'],
            ['id'=>5, 'name'=>'barang keluar', 'guard_name'=>'web'],
            ['id'=>6, 'name'=>'laporan barang masuk', 'guard_name'=>'web'],
            ['id'=>7, 'name'=>'laporan barang keluar', 'guard_name'=>'web'],
        ];
        DB::table('permissions')->insert($permissions);

        // permission
        $role_has_permissions = [
            ['permission_id'=>1, 'role_id'=>1],
            ['permission_id'=>2, 'role_id'=>1],
            ['permission_id'=>2, 'role_id'=>2],
            ['permission_id'=>3, 'role_id'=>2],
            ['permission_id'=>4, 'role_id'=>2],
            ['permission_id'=>4, 'role_id'=>3],
            ['permission_id'=>5, 'role_id'=>2],
            ['permission_id'=>5, 'role_id'=>3],
            ['permission_id'=>6, 'role_id'=>2],
            ['permission_id'=>6, 'role_id'=>3],
            ['permission_id'=>7, 'role_id'=>2],
            ['permission_id'=>7, 'role_id'=>3],
        ];
        DB::table('role_has_permissions')->insert($role_has_permissions);
    }
}
