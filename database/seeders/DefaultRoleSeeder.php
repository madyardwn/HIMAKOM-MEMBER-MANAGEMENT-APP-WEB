<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin Role
        Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());

        // Create Default Roles Non Active Users
        Role::create(['name' => 'non-active-users']);

        Role::create(['name' => 'ketua-himpunan'])->givePermissionTo([
            // Cabinets
            'read-cabinets',
            'create-cabinets',
            'update-cabinets',
            'delete-cabinets',

            // Departments
            'read-departments',
            'create-departments',
            'update-departments',
            'delete-departments',
        ]);

        Role::create(['name' => 'wakil-ketua-himpunan'])->givePermissionTo([
            // Cabinets
            'read-cabinets',
            'create-cabinets',
            'update-cabinets',
            'delete-cabinets',

            // Departments
            'read-departments',
            'create-departments',
            'update-departments',
            'delete-departments',
        ]);

        Role::create(['name' => 'ketua-divisi'])->givePermissionTo([
            // Programs
            'read-programs',
            'create-programs',
            'update-programs',
            'delete-programs',

            // Departments
            'read-departments',
            'update-departments',

            // Events
            'read-events',
            'create-events',
            'update-events',
            'delete-events',
        ]);

        Role::create(['name' => 'wakil-ketua-divisi'])->givePermissionTo([
            // Programs
            'read-programs',
            'create-programs',
            'update-programs',
            'delete-programs',

            // Departments
            'read-departments',
            'update-departments',

            // Events
            'read-events',
            'create-events',
            'update-events',
            'delete-events',
        ]);

        Role::create(['name' => 'ketua-majelis-perwakilan-anggota'])->givePermissionTo([
            'read-users',
            'read-cabinets',
            'read-departments',
            'read-programs',
            'read-events',
        ]);

        Role::create(['name' => 'wakil-ketua-majelis-perwakilan-anggota'])->givePermissionTo([
            'read-users',
            'read-cabinets',
            'read-departments',
            'read-programs',
            'read-events',
        ]);

        Role::create(['name' => 'staf-ahli'])->givePermissionTo([
            // Programs
            'read-programs',
            'create-programs',
            'update-programs',
            'delete-programs',

            // Events
            'read-events',
            'create-events',
            'update-events',
            'delete-events',
        ]);


        Role::create(['name' => 'staf-muda'])->givePermissionTo([
            // Programs
            'read-programs'
        ]);
    }
}
