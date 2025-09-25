<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\TestYearController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StudentCardController;
use App\Http\Controllers\Admin\DashboardController;

/**
 * ---------------------------------------------
 * Root & Public Pages
 * ---------------------------------------------
 */

// Root Welcome Page
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'      => Route::has('login'),
        'canRegister'   => Route::has('register'),
        'laravelVersion'=> Application::VERSION,
        'phpVersion'    => PHP_VERSION,
    ]);
});

// Registration Page
Route::get('register', fn() => Inertia::render('Auth/Register'));

// Static Policy Pages
Route::get('/terms',         fn() => Inertia::render('terms_and_condition'))->name('terms');
Route::get('/return-policy', fn() => Inertia::render('return_policy'))->name('return_policy');
Route::get('/privacy',       fn() => Inertia::render('privacy'))->name('privacy');

/**
 * ---------------------------------------------
 * Student Registration Card & QR Code
 * ---------------------------------------------
 */
Route::get('/student/{id}/card',      [StudentCardController::class, 'show'])->name('student.card.qr');
Route::get('/student/{id}/card-data', [StudentCardController::class, 'cardData'])->name('student.card.data');

/**
 * ---------------------------------------------
 * API Routes
 * ---------------------------------------------
 */
Route::get('/api/admins', [ProfileController::class, 'getAdmins'])->name('api.admins');

/**
 * ---------------------------------------------
 * Authenticated User Routes
 * ---------------------------------------------
 */
Route::middleware('auth')->group(function () {

    // Profile Management
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Management
    Route::get('/student/{student}/edit', [StudentRegistrationController::class, 'editStudentPage'])->name('student.edit');
    Route::put('/student/{student}',      [StudentRegistrationController::class, 'updateStudent'])->name('student.update');
    Route::get('/student/{student}',      [StudentRegistrationController::class, 'studentDetails'])->name('student.details');

    // Dashboard
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // Dashboard Student Data
    Route::get('/Studen/list', [StudentRegistrationController::class, 'studentData'])->name('madrashaDashboard.studentData');
    Route::get('/api/dashboard/student-stats', [StudentRegistrationController::class, 'studentStats'])->name('api.dashboard.student-stats');

    // User Centers API (dummy)
    Route::get('/api/user-centers', fn() => response()->json([]));
});

/**
 * ---------------------------------------------
 * Management Pages
 * ---------------------------------------------
 */
Route::get('/FoodManagement', fn() => Inertia::render('food/FoodManagement'))->name('food.FoodManagement');
Route::get('/FeeManagement',  fn() => Inertia::render('admin/fees/FeeManagement'))->name('fees.FeeManagement');

/**
 * ---------------------------------------------
 * TestYear Functionality
 * ---------------------------------------------
 */
Route::prefix('test-years')->group(function () {
    Route::get('/',        [TestYearController::class, 'index'])->name('test.years.index');
    Route::get('/all',     [TestYearController::class, 'getAllYears'])->name('test.years.all');
    Route::post('/convert',[TestYearController::class, 'convertYear'])->name('test.years.convert');
});





Route::get('admin/dashboard-stats', [DashboardController::class, 'dashboardStats']);
// Route::get('admin/notices', [DashboardController::class, 'notices']);
// Route::get('admin/notices', [DashboardController::class, 'notices']); // If you have a notices method
/**
 * ---------------------------------------------
 * Include Other Route Files
 * ---------------------------------------------
 */
require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';
require __DIR__ . '/Admin.php';
require __DIR__ . '/api.php';

