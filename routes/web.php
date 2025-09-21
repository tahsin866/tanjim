<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\TestYearController;
use App\Http\Controllers\SslCommerzPaymentController;

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
Route::get('/terms',           fn() => Inertia::render('terms_and_condition'))->name('terms');
Route::get('/return-policy',   fn() => Inertia::render('return_policy'))->name('return_policy');
Route::get('/privacy',         fn() => Inertia::render('privacy'))->name('privacy');

// API Routes
Route::get('/api/admins', [ProfileController::class, 'getAdmins'])->name('api.admins');

// Authenticated User Routes
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student
    Route::get('/student/{student}/edit', [StudentRegistrationController::class, 'editStudentPage'])->name('student.edit');
    Route::put('/student/{student}', [StudentRegistrationController::class, 'updateStudent'])->name('student.update');
    Route::get('/student/{student}', [StudentRegistrationController::class, 'studentDetails'])->name('student.details');

    // Dashboard
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // Student Data for Dashboard
    Route::get('/Studen/list', [StudentRegistrationController::class, 'studentData'])->name('madrashaDashboard.studentData');
    Route::get('/api/dashboard/student-stats', [StudentRegistrationController::class, 'studentStats'])->name('api.dashboard.student-stats');

    // User Centers API (dummy)
    Route::get('/api/user-centers', fn() => response()->json([]));
});

// Food & Fee Management Pages
Route::get('/FoodManagement', fn() => Inertia::render('food/FoodManagement'))->name('food.FoodManagement');
Route::get('/FeeManagement',  fn() => Inertia::render('admin/fees/FeeManagement'))->name('fees.FeeManagement');

// TestYear Functionality
Route::prefix('test-years')->group(function () {
    Route::get('/',        [TestYearController::class, 'index'])->name('test.years.index');
    Route::get('/all',     [TestYearController::class, 'getAllYears'])->name('test.years.all');
    Route::post('/convert',[TestYearController::class, 'convertYear'])->name('test.years.convert');
});

// SSLCommerz Payment Example Pages
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

// SSLCommerz Payment Routes
Route::match(['GET', 'POST'], '/success', [SslCommerzPaymentController::class, 'success'])->name('payment.success');
Route::match(['GET', 'POST'], '/fail',    [SslCommerzPaymentController::class, 'fail'])->name('payment.fail');
Route::match(['GET', 'POST'], '/cancel',  [SslCommerzPaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn'])->name('payment.ipn');
Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax'])->name('pay-via-ajax');

// Include Other Route Files
require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';
require __DIR__ . '/Admin.php';
require __DIR__ . '/api.php';