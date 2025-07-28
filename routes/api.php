<?php

// Ensure Composer's autoloader is included if running standalone scripts
// require __DIR__.'/../vendor/autoload.php';


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardApplicationController;
use App\Http\Controllers\Admin\DashboardController;
// Marhala Controller Routes

Route::prefix('api')->group(function () {

Route::post('/submit-all-applications', [App\Http\Controllers\StudentRegistrationController::class, 'submitAllApplications'])->name('submit.all.applications');

// Admin Dashboard Stats Route
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard-stats', [DashboardController::class, 'studentStats']);
    Route::get('/admin/notices', [DashboardController::class, 'getNotices']);
});

});
