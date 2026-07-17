<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role_name'   => 'Super Admin',
                'slug'        => 'super_admin',
                'description' => 'Full system access',
                'status'      => 1,
            ],
            [
                'role_name'   => 'Admin',
                'slug'        => 'admin',
                'description' => 'Administrative access',
                'status'      => 1,
            ],
            [
                'role_name'   => 'Teacher',
                'slug'        => 'teacher',
                'description' => 'Teacher access',
                'status'      => 1,
            ],
            [
                'role_name'   => 'Student',
                'slug'        => 'student',
                'description' => 'Student app user',
                'status'      => 1,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                [
                    'role_name'   => $role['role_name'],
                    'description' => $role['description'],
                    'status'      => $role['status'],
                ]
            );
        }
    }
}
