<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Auth routes (login, register, password reset, email verification)
|--------------------------------------------------------------------------
*/

Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Notice board — any verified user (admin or student)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/notices/{notice}/download', [NoticeController::class, 'download'])
        ->name('notices.download');

});

/*
|--------------------------------------------------------------------------
| Student-only area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified','student'])->group(function () {

    Route::get('/dashboard', [StudentDashboardController::class, 'index'])
        ->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| Admin-only area
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')
    ->middleware(['auth','verified','admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminNoticeController::class, 'dashboard'])->name('dashboard');
        Route::get('/notices/create', [AdminNoticeController::class, 'create'])->name('notices.create');
        Route::post('/notices', [AdminNoticeController::class, 'store'])->name('notices.store');
        Route::delete('/notices/{notice}', [AdminNoticeController::class, 'destroy'])->name('notices.destroy');

    });