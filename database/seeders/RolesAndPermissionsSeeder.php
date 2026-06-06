<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = config('role_permissions.roles');
        $permissions = config('role_permissions.permissions');


        // Create Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'super-admin',
                'permissions' => json_encode($roles['super-admin']),
                'email_verified_at' => now(),
            ]
        );

        // Create Admin
        User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'permissions' => json_encode($roles['admin']),
                'email_verified_at' => now(),
            ]
        );

        // Create Normal User
        User::updateOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'permissions' => json_encode($roles['user']),
                'email_verified_at' => now(),
            ]
        );
    }
}
