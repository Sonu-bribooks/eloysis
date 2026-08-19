<?php
use Illuminate\Support\Facades\Route;

if (! function_exists('menu_active')) {

    function menu_active(string $menu): bool
    {
        $menus = [
            'website' => [
                'admin.home-slider.*',
                'admin.news.*',
                'admin.events.*',
                'admin.gallery.*',
                'admin.contact-messages.*',
            ],

            'academic' => [
                'admin.academic.*',
                'admin.classes.*',
                'admin.sections.*',
                'admin.class-sections.*',
                'admin.subjects.*',
                'admin.clsubject.*',
                'admin.teachers.*',
                'admin.teacher-subject.*',
            ],

            'students' => [
                'admin.students.*',
                'admin.student-promotions.*',
                'admin.attendance.*',
            ],

            'examinations' => [
                'admin.exams.*',
                'admin.questions.*',
                'admin.results.*',
            ],

            'users' => [
                'admin.roles.*',
                'admin.staffs.*',
            ],

            'settings' => [
                'admin.logs.*',
                'admin.settings.*',
            ],

        ];

        return isset($menus[$menu])
            && Route::is($menus[$menu]);
    }
}


if (! function_exists('menu_item_active')) {

    function menu_item_active(string|array $routes): string
    {
        return Route::is($routes)
            ? 'active'
            : '';
    }
}