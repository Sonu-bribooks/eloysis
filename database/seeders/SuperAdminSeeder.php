<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Get super admin role
        $superAdminRole = Role::where('slug', 'super_admin')->first();

        if (! $superAdminRole) {
            $this->command->error('Super admin role not found. Please run RoleSeeder first.');

            return;
        }

        // 2) Assign all permissions to super admin role
        $allPermissionIds = Permission::pluck('id')->toArray();
        $superAdminRole->permissions()->sync($allPermissionIds);

        // 3) Create or update super admin user
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'], // change later
            [
                'name' => 'Super Admin',
                'mobile' => '9999999999', // optional if your users table has mobile
                'role_id' => $superAdminRole->id,
                'password' => Hash::make('Admin@123'), // change after first login
                'status' => 1,
                'email_verified_at' => now(), // if column exists
            ]
        );

        // Optional safety: ensure role_id remains super_admin
        if ((int) $superAdmin->role_id !== (int) $superAdminRole->id) {
            $superAdmin->update([
                'role_id' => $superAdminRole->id,
            ]);
        }

        $this->command->info('Super Admin seeded successfully.');
        // $this->command->info('Email: superadmin@example.com');
        // $this->command->info('Password: Admin@123');
    }
}
