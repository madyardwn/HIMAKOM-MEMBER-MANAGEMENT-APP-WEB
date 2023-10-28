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

        Role::create([
            'name' => 'ketua-himpunan',
            'name' => 'wakil-ketua himpunan'
        ])->givePermissionTo([
            // Cabinets
            'access-cabinets',
            'read-cabinets',
            'create-cabinets',
            'update-cabinets',
            'delete-cabinets',

            // Departments
            'access-departments',
            'read-departments',
            'create-departments',
            'update-departments',
            'delete-departments',
        ]);

        Role::create([
            'name' => 'ketua-divisi',
            'name' => 'wakil-ketua-divisi'
        ])->givePermissionTo([
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

        Role::create([
            'name' => 'ketua-majelis-perwakilan-anggota',
            'name' => 'wakil-ketua-majelis-perwakilan-anggota'
        ])->givePermissionTo([
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
