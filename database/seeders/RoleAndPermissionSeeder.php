<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles/permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // -----------------------------
        // Create Permissions (Optional)
        // -----------------------------
        $permissions = [
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'user.role_assign',
            'user.role_remove',


            'product.view',
            'product.create',
            'product.edit',
            'product.delete',

            'invoice.view',
            'invoice.create',
            'invoice.edit',
            'invoice.delete',

            'customer.view',
            'customer.create',
            'customer.edit',
            'customer.delete',

            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',

            //role
            'role.view', 'role.create', 'role.edit', 'role.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // -----------------------------
        // Create Roles
        // -----------------------------

        $roles = [
            'superadmin', 'admin', 'manager', 'employee', 'customer'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        Role::findByName('superadmin')->syncPermissions(Permission::all());

        // -----------------------------
        // Assign permissions to roles
        // -----------------------------

        $superadmin = Role::findByName('superadmin');
        $admin = Role::findByName('admin');
        $manager = Role::findByName('manager');
        $employee = Role::findByName('employee');
        $customer = Role::findByName('customer');
    }
}

