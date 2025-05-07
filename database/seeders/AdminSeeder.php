<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $user = User::create(['name' => 'Superadmin', 'email' => 'superadmin@yesmachinery.ae', 'password' => 'password123']);

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign existing permissions
        Role::create(['guard_name' => 'web', 'name' => 'superadmin']);
        $user->assignRole('superadmin');
        Role::create(['guard_name' => 'web', 'name' => 'admin']);
    }
}
