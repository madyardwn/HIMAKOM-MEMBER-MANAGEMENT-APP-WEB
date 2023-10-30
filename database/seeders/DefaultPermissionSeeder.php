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
            'access-users',
            'read-users',
            'create-users',
            'update-users',
            'delete-users',

            'access-notifications',
            'read-notifications',
            'create-notifications',
            // 'update-notifications',
            'delete-notifications',

            'access-auth-web-roles',
            'read-auth-web-roles',
            'create-auth-web-roles',
            'update-auth-web-roles',
            'delete-auth-web-roles',

            'access-auth-web-permissions',
            'read-auth-web-permissions',
            // 'create-auth-web-permissions',
            // 'update-auth-web-permissions',
            // 'delete-auth-web-permissions',

            // 'access-auth-api-roles',
            // 'read-auth-api-roles',
            // 'create-auth-api-roles',
            // 'update-auth-api-roles',
            // 'delete-auth-api-roles',

            // 'access-auth-api-permissions',
            // 'read-auth-api-permissions',
            // 'create-auth-api-permissions',
            // 'update-auth-api-permissions',
            // 'delete-auth-api-permissions',

            'access-cabinets',
            'read-cabinets',
            'create-cabinets',
            'update-cabinets',
            'delete-cabinets',

            'access-filosofies',
            'read-filosofies',
            'create-filosofies',
            'update-filosofies',
            'delete-filosofies',

            'access-departments',
            'read-departments',
            'create-departments',
            'update-departments',
            'delete-departments',

            'access-programs',
            'read-programs',
            'create-programs',
            'update-programs',
            'delete-programs',

            'access-events',
            'read-events',
            'create-events',
            'update-events',
            'delete-events',

            // 'access-news',
            // 'read-news',
            // 'create-news',
            // 'update-news',
            // 'delete-news',

            // 'access-articles',
            // 'read-articles',
            // 'create-articles',
            // 'update-articles',
            // 'delete-articles',

            // 'access-galleries',
            // 'read-galleries',
            // 'create-galleries',
            // 'update-galleries',
            // 'delete-galleries',

            // 'access-videos',
            // 'read-videos',
            // 'create-videos',
            // 'update-videos',
            // 'delete-videos',

            // 'access-documents',
            // 'read-documents',
            // 'create-documents',
            // 'update-documents',
            // 'delete-documents',

            'access-activity-logs',
            'read-activity-logs',
            // 'create-activity-logs',
            // 'update-activity-logs',
            // 'delete-activity-logs',

            'access-telescope',
            'read-telescope',
            // 'create-telescope',
            // 'update-telescope',
            // 'delete-telescope',

            // 'access-cv-himakom',
            // 'read-cv-himakom',
            // 'create-cv-himakom',
            // 'update-cv-himakom',
            // 'delete-cv-himakom',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
