<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permission = [
            'read',
            'create',
            'update',
            'delete',
        ];

        $models = [
            'user',
            'auth-web',
            'cabinet',
            'filosofie',
            'department',
            'program',
            'event',
        ];

        foreach ($models as $model) {
            foreach ($permission as $perm) {
                Permission::create(['name' => "{$perm}-{$model}"]);
            }
        }        
    }
}
