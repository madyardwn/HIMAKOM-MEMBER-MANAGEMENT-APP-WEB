<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permission = [
            'access',
            'read',
            'create',
            'update',
            'delete',
        ];

        $models = [
            'users',
            'auth-web-roles',
            'auth-web-permissions',
            'auth-api-roles',
            'auth-api-permissions',
            'cabinets',
            'filosofies',
            'departments',
            'programs',
            'events',
            // 'news',
            // 'articles',
            // 'galleries',
            // 'videos',
            // 'documents',
            'activity-logs',
            'telescope',
            'cv-himakom'
        ];

        foreach ($models as $model) {
            foreach ($permission as $perm) {
                Permission::create(['name' => "{$perm}-{$model}"]);
            }
        }
    }
}
