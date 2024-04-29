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

        Permission::create(['name' => 'gerer prejects']);
        
        Permission::create(['name' => 'gerer tasks']);

        Permission::create(['name' => 'gerer offers']);

        Permission::create(['name' => 'gerer demandes']);

        Permission::create(['name' => 'gerer users']);
        
        Permission::create(['name' => 'gerer admins']);

        Role::create(['name' => 'supervisor'])->givePermissionTo(['gerer prejects','gerer tasks']);

        Role::create(['name' => 'admin'])->givePermissionTo(['gerer offers','gerer demandes','gerer users']);
        
        Role::create(['name' => 'intern'])->givePermissionTo(['gerer tasks','gerer prejects']);

        Role::create(['name' => 'user']);
        
        Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
    }
}