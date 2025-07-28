<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\admin\marhala_for_admin\Marhala;
use App\Http\Controllers\ScheduleSetupController;
use App\Http\Controllers\MarhalaListController;
use App\Http\Controllers\MadrashaController;
use App\Http\Controllers\MarhalaController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DivishionController;
use App\Http\Controllers\ExamSetupController;
use App\Http\Controllers\MarkazAgreementController;
use App\Http\Controllers\BoardApplicationController;
use App\Http\Controllers\Admin\DocumentApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminForgotPasswordController;

// Admin Forgot Password Routes
Route::get('/admin/forgot-password', [AdminForgotPasswordController::class, 'showEmailForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AdminForgotPasswordController::class, 'sendOtp'])->name('admin.password.email');
Route::get('/admin/verify-otp', [AdminForgotPasswordController::class, 'showOtpForm'])->name('admin.password.verify-otp');
Route::post('/admin/verify-otp', [AdminForgotPasswordController::class, 'verifyOtp'])->name('admin.password.verify');
Route::get('/admin/reset-password', [AdminForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset-form');
Route::post('/admin/reset-password', [AdminForgotPasswordController::class, 'resetPassword'])->name('admin.password.update');
Route::post('/admin/resend-otp', [AdminForgotPasswordController::class, 'resendOtp'])->name('admin.password.resend');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// ============= মারহালা সেটাপ =============














// AdminUserController
Route::get('/user-create-for-admin', [AdminUserController::class, 'create'])->name('user_create_for_admin.user_create_for_admin');
Route::post('/user-create-for-admin', [AdminUserController::class, 'store'])->name('user_create_for_admin.store');
Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])->name('user_create_for_admin.admin_user_edit');
Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('user_create_for_admin.update');
Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('user_create_for_admin.destroy');

// DivishionController
// Route::get('/divisions', [DivishionController::class, 'getDivisions'])->name('admin.divisions');
// Route::get('/divisions/{divisionId}/districts', [DivishionController::class, 'getDistricts'])->name('admin.districts');
// Route::get('/districts/{districtId}/thanas', [DivishionController::class, 'getThanas'])->name('admin.thanas');


Route::get('api/divisions', [DivishionController::class, 'getDivisions']);
Route::get('api/districts/{division}', [DivishionController::class, 'getDistricts']);
Route::get('api/thanas/{district}', [DivishionController::class, 'getThanas']);

// Document Applications - routes moved to admin_auth.php
