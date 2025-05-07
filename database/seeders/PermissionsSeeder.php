<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder {

    public function run() {
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'settings']);

        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'employee_create']);
        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'employee_read']);
        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'employee_update']);
        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'employee_delete']);

        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'role_create']);
        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'role_read']);
        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'role_update']);
        Permission::firstOrCreate(['guard_name' => 'web', 'name' => 'role_delete']);
    }
}
