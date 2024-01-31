<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class DefaultPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'read-users',
            'create-users',
            'update-users',
            'delete-users',

            'read-notifications',
            'create-notifications',
            // 'update-notifications',
            'delete-notifications',

            'read-auth-web-roles',
            'create-auth-web-roles',
            'update-auth-web-roles',
            'delete-auth-web-roles',

            'read-auth-web-permissions',
            // 'create-auth-web-permissions',
            // 'update-auth-web-permissions',
            // 'delete-auth-web-permissions',

            // 'read-auth-api-roles',
            // 'create-auth-api-roles',
            // 'update-auth-api-roles',
            // 'delete-auth-api-roles',

            // 'read-auth-api-permissions',
            // 'create-auth-api-permissions',
            // 'update-auth-api-permissions',
            // 'delete-auth-api-permissions',

            'read-cabinets',
            'create-cabinets',
            'update-cabinets',
            'delete-cabinets',

            'read-filosofies',
            'create-filosofies',
            'update-filosofies',
            'delete-filosofies',

            'read-dbus',
            'create-dbus',
            'update-dbus',
            'delete-dbus',

            'read-programs',
            'create-programs',
            'update-programs',
            'delete-programs',

            'read-events',
            'create-events',
            'update-events',
            'delete-events',

            // 'read-news',
            // 'create-news',
            // 'update-news',
            // 'delete-news',

            // 'read-articles',
            // 'create-articles',
            // 'update-articles',
            // 'delete-articles',

            // 'read-galleries',
            // 'create-galleries',
            // 'update-galleries',
            // 'delete-galleries',

            // 'read-videos',
            // 'create-videos',
            // 'update-videos',
            // 'delete-videos',

            // 'read-documents',
            // 'create-documents',
            // 'update-documents',
            // 'delete-documents',

            'read-activity-logs',
            // 'create-activity-logs',
            // 'update-activity-logs',
            // 'delete-activity-logs',

            'read-telescope',
            // 'create-telescope',
            // 'update-telescope',
            // 'delete-telescope',

            // 'read-cv-himakom',
            // 'create-cv-himakom',
            // 'update-cv-himakom',
            // 'delete-cv-himakom',

            'read-work-histories',

            'read-complaints',
            'create-complaints',
            'update-complaints',
            'delete-complaints',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
