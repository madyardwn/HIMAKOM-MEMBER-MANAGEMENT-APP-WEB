<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DefaultPermissionsSeeder::class);

        // Create Super Admin Role
        $role = Role::create(['name' => 'super-admin']);

        // Create Super Admin User
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@polban.ac.id',
            'password' => bcrypt('neracietas36'),
        ]);

        // Assign Super Admin Role to Super Admin User
        $user->assignRole($role->name);

        // Assign All Permissions to Super Admin Role
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
    }
}
