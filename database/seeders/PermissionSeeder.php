<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'dashboard.view', 'module' => 'dashboard'],

            // Roles
            ['name' => 'View Roles', 'slug' => 'roles.view', 'module' => 'roles'],
            ['name' => 'Create Roles', 'slug' => 'roles.create', 'module' => 'roles'],
            ['name' => 'Edit Roles', 'slug' => 'roles.edit', 'module' => 'roles'],
            ['name' => 'Delete Roles', 'slug' => 'roles.delete', 'module' => 'roles'],

            // Permissions
            ['name' => 'View Permissions', 'slug' => 'permissions.view', 'module' => 'permissions'],
            ['name' => 'Create Permissions', 'slug' => 'permissions.create', 'module' => 'permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'permissions.edit', 'module' => 'permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'permissions.delete', 'module' => 'permissions'],

            // Admin users
            ['name' => 'View Admin Users', 'slug' => 'admins.view', 'module' => 'admins'],
            ['name' => 'Create Admin Users', 'slug' => 'admins.create', 'module' => 'admins'],
            ['name' => 'Edit Admin Users', 'slug' => 'admins.edit', 'module' => 'admins'],
            ['name' => 'Delete Admin Users', 'slug' => 'admins.delete', 'module' => 'admins'],

            // Students
            ['name' => 'View Students', 'slug' => 'students.view', 'module' => 'students'],
            ['name' => 'Create Students', 'slug' => 'students.create', 'module' => 'students'],
            ['name' => 'Edit Students', 'slug' => 'students.edit', 'module' => 'students'],
            ['name' => 'Delete Students', 'slug' => 'students.delete', 'module' => 'students'],

            // Classes
            ['name' => 'View Classes', 'slug' => 'classes.view', 'module' => 'classes'],
            ['name' => 'Create Classes', 'slug' => 'classes.create', 'module' => 'classes'],
            ['name' => 'Edit Classes', 'slug' => 'classes.edit', 'module' => 'classes'],
            ['name' => 'Delete Classes', 'slug' => 'classes.delete', 'module' => 'classes'],

            // Subjects
            ['name' => 'View Subjects', 'slug' => 'subjects.view', 'module' => 'subjects'],
            ['name' => 'Create Subjects', 'slug' => 'subjects.create', 'module' => 'subjects'],
            ['name' => 'Edit Subjects', 'slug' => 'subjects.edit', 'module' => 'subjects'],
            ['name' => 'Delete Subjects', 'slug' => 'subjects.delete', 'module' => 'subjects'],

            // Questions
            ['name' => 'View Questions', 'slug' => 'questions.view', 'module' => 'questions'],
            ['name' => 'Create Questions', 'slug' => 'questions.create', 'module' => 'questions'],
            ['name' => 'Edit Questions', 'slug' => 'questions.edit', 'module' => 'questions'],
            ['name' => 'Delete Questions', 'slug' => 'questions.delete', 'module' => 'questions'],

            // Exams
            ['name' => 'View Exams', 'slug' => 'exams.view', 'module' => 'exams'],
            ['name' => 'Create Exams', 'slug' => 'exams.create', 'module' => 'exams'],
            ['name' => 'Edit Exams', 'slug' => 'exams.edit', 'module' => 'exams'],
            ['name' => 'Delete Exams', 'slug' => 'exams.delete', 'module' => 'exams'],

            // Exam questions
            ['name' => 'View Exam Questions', 'slug' => 'exam_questions.view', 'module' => 'exam_questions'],
            ['name' => 'Assign Exam Questions', 'slug' => 'exam_questions.create', 'module' => 'exam_questions'],
            ['name' => 'Delete Exam Questions', 'slug' => 'exam_questions.delete', 'module' => 'exam_questions'],

            // Results
            ['name' => 'View Results', 'slug' => 'results.view', 'module' => 'results'],
            ['name' => 'Export Results', 'slug' => 'results.export', 'module' => 'results'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'],
                    'module' => $permission['module'],
                    'status' => 1,
                    'description' => null,
                ]
            );
        }
    }
}
