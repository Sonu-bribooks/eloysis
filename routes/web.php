<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ExamQuestionController;
use App\Http\Controllers\Admin\ResultController;

use App\Http\Controllers\Admin\{RoleController,AcademicSessionController,AcademicClassController};

require __DIR__ . '/website.php';
// require __DIR__ . '/admin.php';

// Route::get('/', function () {
//     return view('welcome');
// });







Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin routes
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Auth admin routes
    Route::middleware(['admin.auth'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('roles')
            ->name('roles.')
            ->controller(RoleController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');

                Route::get('/list', 'list')->name('list');

                Route::post('/', 'store')->name('store');

                Route::get('/{role}/edit', 'edit')->name('edit');

                Route::put('/{role}', 'update')->name('update');

                Route::delete('/{role}', 'destroy')->name('destroy');

                Route::patch('/{role}/status', 'changeStatus')->name('status');

            });
        
        Route::prefix('academic')
            ->name('academic.')
            ->controller(AcademicSessionController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');

                Route::get('/list', 'list')->name('list');

                Route::post('/', 'store')->name('store');

                Route::get('/{academic}/edit', 'edit')->name('edit');

                Route::put('/{academic}', 'update')->name('update');

                Route::delete('/{academic}', 'destroy')->name('destroy');

                Route::patch('/{academic}/status', 'changeStatus')->name('status');

            });

        Route::prefix('classes')
            ->name('classes.')
            ->controller(AcademicClassController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');

                Route::get('/list', 'list')->name('list');

                Route::post('/', 'store')->name('store');

                Route::get('/{classes}/edit', 'edit')->name('edit');

                Route::put('/{classes}', 'update')->name('update');

                Route::delete('/{classes}', 'destroy')->name('destroy');

                Route::patch('/{classes}/status', 'changeStatus')->name('status');

            });

        // Route::resource('classes', AcademicClassController::class);

        // Route::get('classes/list', [AcademicClassController::class, 'list'])
        //     ->name('classes.list');

        // Route::patch('classes/{classes}/status', [AcademicClassController::class, 'changeStatus'])
        //     ->name('classes.status');
            

        Route::resource('students', StudentController::class);
        // Route::resource('classes', ClassController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('exams', ExamController::class);
        Route::resource('questions', QuestionController::class);

        // Route::get('exams/{exam}/questions', [ExamQuestionController::class, 'index'])->name('exams.questions.index');
        // Route::post('exams/{exam}/questions', [ExamQuestionController::class, 'store'])->name('exams.questions.store');
        // Route::delete('exams/{exam}/questions/{question}', [ExamQuestionController::class, 'destroy'])->name('exams.questions.destroy');

        Route::get('results', [ResultController::class, 'index'])->name('results.index');
        Route::get('results/exam/{exam}', [ResultController::class, 'examResults'])->name('results.exam');
        Route::get('results/student/{student}', [ResultController::class, 'studentResults'])->name('results.student');
    });
});
