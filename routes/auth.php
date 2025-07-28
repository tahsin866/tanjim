<?php
use App\Http\Controllers\Auth\madrasha_check_for_userController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\userRegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware('guest')->group(function () {


    Route::post('register', [userRegisteredUserController::class, 'store'])
        ->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [ForgotPasswordController::class, 'showEmailForm'])
        ->name('password.request');

    Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.email');

    Route::get('verify-otp', [ForgotPasswordController::class, 'showOtpForm'])
        ->name('password.verify-otp');

    Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
        ->name('password.verify-otp.post');

    Route::get('reset-password-form', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset-form');

    Route::post('reset-password-form', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.reset-form.post');

    Route::post('resend-otp', [ForgotPasswordController::class, 'resendOtp'])
        ->name('password.resend-otp');






});






Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
