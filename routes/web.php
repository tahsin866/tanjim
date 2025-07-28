<?php
use App\Http\Controllers\MarhalaController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\markazChangeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\SubjectSettingsController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\teacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarhalaListController;
use Inertia\Inertia;
use App\Models\admin\marhala_for_admin\Marhala;
use App\Http\Controllers\ExamSetupController;
use App\Http\Controllers\Auth\madrasha_check_for_userController;
use App\Http\Controllers\Auth\userRegisteredUserController;
use App\Http\Controllers\Admin\DashboardController;
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

    // Student Edit Route
    Route::get('/student/{student}/edit', [StudentRegistrationController::class, 'editStudentPage'])->name('student.edit');
    Route::put('/student/{student}', [StudentRegistrationController::class, 'updateStudent'])->name('student.update');
    Route::get('/student/{student}', [StudentRegistrationController::class, 'studentDetails'])->name('student.details');



});



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/dashboard-stats', [DashboardController::class, 'statsApi']);
});

// সাবজেক্ট সেটিংস










    Route::get('/api/admins', [ProfileController::class, 'getAdmins'])->name('api.admins');



    // Route::post('madrasha_check_for_user', [madrasha_check_for_userController::class, 'check'])->name('madrasha.check');


    // Registration Routes
    Route::get('register', function () {
        return inertia::render('Auth/Register');
    })->name('register');

    Route::get('Register', function () {
        return inertia::render('Auth/Register');
    })->name('Register');


    // Route::get('register', [userRegisteredUserController::class, 'create'])->middleware('check.madrasha.access')
    // ->name('register');



require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';

require __DIR__ . '/Madrasha.php';

require __DIR__ . '/Admin.php';
require __DIR__ . '/api.php';

// Test routes for SessionYear functionality
use App\Http\Controllers\TestYearController;

Route::prefix('test-years')->group(function () {
    Route::get('/', [TestYearController::class, 'index'])->name('test.years.index');
    Route::get('/all', [TestYearController::class, 'getAllYears'])->name('test.years.all');
    Route::post('/convert', [TestYearController::class, 'convertYear'])->name('test.years.convert');
});
