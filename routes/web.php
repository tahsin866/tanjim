<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\TestYearController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Edit Routes
    Route::get('/student/{student}/edit', [StudentRegistrationController::class, 'editStudentPage'])->name('student.edit');
    Route::put('/student/{student}', [StudentRegistrationController::class, 'updateStudent'])->name('student.update');
    Route::get('/student/{student}', [StudentRegistrationController::class, 'studentDetails'])->name('student.details');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/dashboard-stats', [DashboardController::class, 'statsApi']);
});

// Student Data & Admins
Route::get('/Studen/list', [StudentRegistrationController::class, 'studentData'])->name('madrashaDashboard.studentData');
Route::put('/students/{id}', [StudentRegistrationController::class, 'updateStudent'])->name('students.update');
Route::get('/api/admins', [ProfileController::class, 'getAdmins'])->name('api.admins');

Route::prefix('api')->group(function () {
    Route::post('/submit-all-applications', [StudentRegistrationController::class, 'submitAllApplications'])->name('submit.all.applications');
    // Admin Dashboard Stats Route
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/admin/dashboard-stats', [DashboardController::class, 'studentStats']);
        Route::get('/admin/notices', [DashboardController::class, 'getNotices']);
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';
require __DIR__ . '/Admin.php';
require __DIR__ . '/api.php';

// Test routes for SessionYear functionality
Route::prefix('test-years')->group(function () {
    Route::get('/', [TestYearController::class, 'index'])->name('test.years.index');
    Route::get('/all', [TestYearController::class, 'getAllYears'])->name('test.years.all');
    Route::post('/convert', [TestYearController::class, 'convertYear'])->name('test.years.convert');
});
