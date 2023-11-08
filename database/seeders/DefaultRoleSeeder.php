<?php

namespace Database\Seeders;

use App\Models\Department;
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
        Role::create(['name' => 'SUPER ADMIN'])->givePermissionTo(Permission::all());

        // Create Default Roles Non Active Users
        Role::create(['name' => 'NON ACTIVE']);

        Role::create(['name' => 'KETUA HIMPUNAN'])->givePermissionTo([
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

        Role::create(['name' => 'WAKIL KETUA HIMPUNAN'])->givePermissionTo([
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

            // Work Histories
            'read-work-histories'
        ]);

        Role::create(['name' => 'KETUA MAJELIS PERWAKILAN ANGGOTA'])->givePermissionTo([
            'read-users',
            'read-cabinets',
            'read-departments',
            'read-programs',
            'read-events',
            'read-work-histories'
        ]);

        Role::create(['name' => 'WAKIL KETUA MAJELIS PERWAKILAN ANGGOTA'])->givePermissionTo([
            'read-users',
            'read-cabinets',
            'read-departments',
            'read-programs',
            'read-events',
            'read-work-histories'
        ]);

        $department = Department::select(['id', 'name'])
            ->whereNotIn('short_name', ['MPA'])
            ->get();

        foreach ($department as $dept) {
            Role::create(['name' => 'KETUA ' . $dept->name])->givePermissionTo([
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

                // Work Histories
                'read-work-histories'
            ]);

            Role::create(['name' => 'WAKIL KETUA ' . $dept->name])->givePermissionTo([
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

                // Work Histories
                'read-work-histories'
            ]);
        }

        Role::create(['name' => 'STAF AHLI'])->givePermissionTo([
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

            // Work Histories
            'read-work-histories'
        ]);

        Role::create(['name' => 'STAF MUDA'])->givePermissionTo([
            // Programs
            'read-programs',

            // Work Histories
            'read-work-histories'
        ]);
    }
}
