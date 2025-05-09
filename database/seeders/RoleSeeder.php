<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {

    public function run() {
        Role::firstOrCreate(['guard_name' => 'web', 'name' => 'servicemanager']);
        Role::firstOrCreate(['guard_name' => 'web', 'name' => 'servicecoordinator']);
        Role::firstOrCreate(['guard_name' => 'web', 'name' => 'servicetechnician']);
        Role::firstOrCreate(['guard_name' => 'web', 'name' => 'dcm']);
    }
}
