<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('welcome');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Notice board (any verified user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/notices/{notice}/download', [NoticeController::class, 'download'])
        ->name('notices.download');
});

/*
|--------------------------------------------------------------------------
| Student-only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified','student'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])
        ->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin-only
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')
    ->middleware(['auth','verified','admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminNoticeController::class, 'dashboard'])
            ->name('dashboard');

        // Notices CRUD
        Route::get('/notices/create', [AdminNoticeController::class, 'create'])
            ->name('notices.create');
        Route::post('/notices', [AdminNoticeController::class, 'store'])
            ->name('notices.store');
        Route::get('/notices/{notice}/edit', [AdminNoticeController::class, 'edit'])
            ->name('notices.edit');
        Route::put('/notices/{notice}', [AdminNoticeController::class, 'update'])
            ->name('notices.update');
        Route::delete('/notices/{notice}', [AdminNoticeController::class, 'destroy'])
            ->name('notices.destroy');

        // Users
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');
        Route::patch('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])
            ->name('users.toggleRole');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');
    });