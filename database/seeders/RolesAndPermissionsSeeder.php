<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'prejects']);
        
        Permission::create(['name' => 'tasks']);

        Permission::create(['name' => 'offers']);

        Permission::create(['name' => 'demands']);

        Permission::create(['name' => 'users']);
        
        Permission::create(['name' => 'admins']);

        Role::create(['name' => 'supervisor'])->givePermissionTo(['prejects','tasks']);

        Role::create(['name' => 'admin'])->givePermissionTo(['offers','demands','users']);
        
        Role::create(['name' => 'intern'])->givePermissionTo(['tasks','prejects']);

        Role::create(['name' => 'user']);
        
        Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
    }
}