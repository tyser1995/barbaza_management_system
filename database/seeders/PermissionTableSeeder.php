<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Reset cached roles and permissions
        //app()[PermissionRegistrar::class]->forgetCachedPermissions();


        $permissions = [
            'dashboard-list',  
            'user-list',
            'user-create',
            'user-store',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-store',
            'role-edit',
            'role-delete',
        ];

        //DB::table('permissions')->truncate();
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
        // foreach ($permissions as $permission) {
        //     Permission::updateOrCreate(['id' => $permission['id']],$permission);
        // }
    }
}
