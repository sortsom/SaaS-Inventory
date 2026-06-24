<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $companyAdmin = Role::firstOrCreate(['name' => 'Company Admin', 'guard_name' => 'web']);
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $warehouseStaff = Role::firstOrCreate(['name' => 'Warehouse Staff', 'guard_name' => 'web']);
        $salesStaff = Role::firstOrCreate(['name' => 'Sales Staff', 'guard_name' => 'web']);
        $staff = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);

        // Permissions super admin has all permissions, so we only need to define permissions for other roles
        $permissions = [
            

            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            'company.view',
            'company.create',
            'company.update',
            'company.delete',

            'product.view',
            'product.create',
            'product.update',
            'product.delete',

            'inventory.view',
            'inventory.create',
            'inventory.update',
            'inventory.adjust',

            // Purchases
            'purchase.view',
            'purchase.create',
            'purchase.update',
            'purchase.approve',
            // Sales
            'sales.view',
            'sales.create',
            'sales.update',
            'sales.approve',

            'supplier.view',
            'supplier.create',
            'supplier.update',
            'supplier.delete',

            'customer.view',
            'customer.create',
            'customer.update',
            'customer.delete',

            // assignment of permissions to roles
            
            'report.view',
        ];

        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        // Super Admin gets all permissions
        $superAdmin->syncPermissions(
            Permission::all()
        );

        // Company Admin gets all permissions except user management, product deletion, and inventory adjustment
        $companyAdmin->syncPermissions([
            'user.view',
            'user.create',
            'user.update',

            'product.view',
            'product.create',
            'product.update',

            'inventory.view',
            'inventory.create',
            'inventory.update',

            'purchase.view',
            'purchase.create',
            'purchase.update',
            'purchase.approve',

            'sales.view',
            'sales.create',
            'sales.update',
            'sales.approve',

            'supplier.view',
            'supplier.create',
            'supplier.update',

            'customer.view',
            'customer.create',
            'customer.update',

            'report.view',
        ]);



    }
}
