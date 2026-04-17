<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Permissions
        $permissions = ['view', 'create', 'edit', 'delete'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        // 3. Assign permissions
        $adminRole->syncPermissions($permissions);
        $userRole->syncPermissions(['view']);

        // 4. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // 5. Create Normal User
        $user = User::firstOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('User');
    }
}
