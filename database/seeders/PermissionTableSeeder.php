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
            // ===== Order Permissions =====
            'order-list',
            'order-view',
            'order-edit',
            'order-delete',
             'order-pending',      // Pending orders page
            'order-processing',   // Processing orders page
            'order-completed',    // Completed orders page
            'order-cancelled', 
            // ===== Product Permissions =====
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',

            // ===== Brand Permissions =====
            'brand-list',
            'brand-create',
            'brand-edit',
            'brand-delete',

            // ===== Category Permissions =====
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',

            // ===== Blog Permissions =====
            'blog-list',
            'blog-create',
            'blog-edit',
            'blog-delete',

            // ===== home Slider Permissions =====
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete',

            // ===== Header Permissions =====
            'header-setting-list',
            'header-setting-create',
            'header-setting-edit',
            'header-setting-delete',
        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
