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
        // Create Super Admin User
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'unit.tekno@gmail.com',
            'password' => bcrypt('unittekno36'),
        ]);

        $this->call(DefaultPermissionSeeder::class); // Create Permissions
        $this->call(DefaultRoleSeeder::class); // Create Roles
        $this->call(DefaultDepartmentSeeder::class); // Create Departments

        $user->assignRole('super-admin'); // Assign Super Admin Role to Super Admin User
    }
}
