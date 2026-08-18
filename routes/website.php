<?php

use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {

    Route::get('/', 'index')->name('home');

    Route::get('/about', 'about')->name('about');

    // Route::get('/contact', 'contact')->name('contact');

    Route::get('/news', 'news')->name('news');

    Route::get('/events', 'events')->name('events');
});

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

// Route::post('/contact', function () {
//     return response()->json([
//         'status' => true,
//         'message' => 'Route Working'
//     ]);
// })->name('contact.store');
