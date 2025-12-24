<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create SuperAdmin role
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);

        // Create Admin role (for admin users created by Super Admin)
        // $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        // Create Super Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        // Assign Super Admin role to user
        $superAdmin->assignRole($superAdminRole);
    }
}
