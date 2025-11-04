<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $permissions = [

            // ===== Dashboard =====
            'dashboard-access',

            // ===== User Permissions =====
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            // ===== Role Permissions =====
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            // ===== Product Permissions =====
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',

            // ===== Blog Permissions =====
            'blog-list',
            'blog-create',
            'blog-edit',
            'blog-delete',

            // ===== Settings Permissions =====
            'settings-list',
            'settings-edit',
            'settings-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
