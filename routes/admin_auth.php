<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DocumentApplicationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin authentication routes for your
| application. These routes are loaded by the RouteServiceProvider.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin routes (not authenticated)
    Route::middleware('guest:admin')->group(function () {
        // Login Routes
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);

        // Registration Routes
        Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
        Route::post('/register', [AdminRegisterController::class, 'register']);
    });

    // Authenticated admin routes
    Route::middleware('auth:admin')->group(function () {
        // Logout Route
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Dashboard Route
        Route::get('/dashboard', function () {
            return Inertia::render('admin/admin_Dashboard');
        })->name('admin_Dashboard');

        // Super Admin only routes
        Route::middleware('super.admin')->group(function () {
            Route::resource('users', AdminUserController::class)->except(['show']);
        });

        // Document Applications routes - All admins can view, specific permissions for actions
        Route::middleware(['auth:admin'])->prefix('documents')->name('documents.')->group(function () {
            Route::get('/applications', [DocumentApplicationController::class, 'index'])->name('applications.index');
            Route::get('/applications/approved', [DocumentApplicationController::class, 'getApproveList'])->name('applications.approved');
            Route::get('/applications/{user}', [DocumentApplicationController::class, 'show'])->name('applications.show');
            Route::patch('/applications/{user}/approve', [DocumentApplicationController::class, 'approve'])->name('applications.approve');
            Route::patch('/applications/{user}/reject', [DocumentApplicationController::class, 'reject'])->name('applications.reject');
            Route::patch('/applications/{user}/suspend', [DocumentApplicationController::class, 'suspend'])->name('applications.suspend');
            Route::delete('/applications/{user}/delete', [DocumentApplicationController::class, 'destroy'])->name('applications.delete');
        });

    });
});
