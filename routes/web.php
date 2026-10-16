<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\Auth\LoginController;
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
| Custom Admin Login
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])
    ->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin'])
    ->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Notice board — verified users
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ✅ NEW: View notice detail page
    Route::get('/notices/{notice}', [NoticeController::class, 'show'])
        ->name('notices.show');

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

        Route::get('/dashboard', [AdminNoticeController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/notices', [AdminNoticeController::class, 'index'])
            ->name('notices.index');

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

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');
        Route::patch('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])
            ->name('users.toggleRole');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');
    });