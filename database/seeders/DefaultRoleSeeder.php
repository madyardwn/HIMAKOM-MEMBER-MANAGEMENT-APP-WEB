<?php

namespace Database\Seeders;

use App\Models\DBU;
use App\Models\Permission;
use App\Models\Role;
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

            // DBUs
            'read-dbus',
            'create-dbus',
            'update-dbus',
            'delete-dbus',

            // Notifications
            'read-notifications',

            'read-complaints',
            'create-complaints',
        ]);

        Role::create(['name' => 'WAKIL KETUA HIMPUNAN'])->givePermissionTo([
            // Cabinets
            'read-cabinets',
            'create-cabinets',
            'update-cabinets',
            'delete-cabinets',

            // DBUs
            'read-dbus',
            'create-dbus',
            'update-dbus',
            'delete-dbus',

            // Work Histories
            'read-work-histories',

            // Complaints
            'read-complaints',
            'create-complaints',
        ]);

        // Bendahara umum
        Role::create(['name' => 'BENDAHARA UMUM'])->givePermissionTo([
            // Cabinets
            'read-cabinets',

            // DBUs
            'read-dbus',

            // Notifications
            'read-notifications',

            // Work Histories
            'read-work-histories',

            // Complaints
            'read-complaints',
            'create-complaints',
        ]);

        // Sekretaris umum
        Role::create(['name' => 'SEKRETARIS UMUM'])->givePermissionTo([
            // Cabinets
            'read-cabinets',

            // DBUs
            'read-dbus',

            // Notifications
            'read-notifications',

            // Work Histories
            'read-work-histories',

            // Complaints
            'read-complaints',
            'create-complaints',
        ]);

        Role::create(['name' => 'KETUA MAJELIS PERWAKILAN ANGGOTA'])->givePermissionTo([
            'read-users',
            'read-cabinets',
            'read-dbus',
            'read-programs',
            'read-events',
            'read-work-histories',
            'read-notifications',

            // Complaints
            'read-complaints',
            'create-complaints',
        ]);

        Role::create(['name' => 'WAKIL KETUA MAJELIS PERWAKILAN ANGGOTA'])->givePermissionTo([
            'read-users',
            'read-cabinets',
            'read-dbus',
            'read-programs',
            'read-events',
            'read-work-histories',
            'read-notifications',

            // Complaints
            'read-complaints',
            'create-complaints',
        ]);

        $dbu = DBU::select(['id', 'name'])
            ->whereNotIn('short_name', ['MPA'])
            ->get();

        foreach ($dbu as $dept) {
            Role::create(['name' => 'KETUA ' . $dept->name])->givePermissionTo([
                // Programs
                'read-programs',
                'create-programs',
                'update-programs',
                'delete-programs',

                // DBUs
                'read-dbus',
                // 'update-dbus',

                // Events
                'read-events',
                'create-events',
                'update-events',
                'delete-events',

                // Work Histories
                'read-work-histories',

                // Notifications
                'read-notifications',
                'create-notifications',

                // Complaints
                'read-complaints',
                'create-complaints',
            ]);

            Role::create(['name' => 'WAKIL KETUA ' . $dept->name])->givePermissionTo([
                // Programs
                'read-programs',
                'create-programs',
                'update-programs',
                'delete-programs',

                // DBUs
                'read-dbus',
                // 'update-dbus',

                // Events
                'read-events',
                'create-events',
                'update-events',
                'delete-events',

                // Work Histories
                'read-work-histories',

                // Complaints
                'read-complaints',
                'create-complaints',
            ]);
        }

        Role::create(['name' => 'STAF AHLI'])->givePermissionTo([
            // Cabinets
            'read-cabinets',

            // Programs
            'read-programs',
            // 'create-programs',
            // 'update-programs',
            // 'delete-programs',

            // Notifications
            'read-notifications',
            'create-notifications',

            // Events
            'read-events',
            'create-events',
            'update-events',
            'delete-events',

            // Work Histories
            'read-work-histories',

            // Complaints
            'read-complaints',
            'create-complaints',
        ]);

        Role::create(['name' => 'STAF MUDA'])->givePermissionTo([
            // Cabinets
            'read-cabinets',

            // Programs
            'read-programs',

            // Work Histories
            'read-work-histories',

            // Complaints
            'read-complaints',
            'create-complaints',
        ]);
    }
}
