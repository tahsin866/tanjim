<?php
use App\Http\Controllers\MarhalaController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\markazChangeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\SubjectSettingsController;
use App\Http\Controllers\TestYearController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\admin\marhala_for_admin\Marhala;
use AppHttp\Controllers\ExamSetupController;
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


// Registration page (GET)
Route::get('register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

// API routes
Route::get('/api/admins', [ProfileController::class, 'getAdmins'])->name('api.admins');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Edit Routes
    Route::get('/student/{student}/edit', [StudentRegistrationController::class, 'editStudentPage'])->name('student.edit');
    Route::put('/student/{student}', [StudentRegistrationController::class, 'updateStudent'])->name('student.update');
    Route::get('/student/{student}', [StudentRegistrationController::class, 'studentDetails'])->name('student.details');

    // User dashboard route
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Student Data route for dashboard
    Route::get('/Studen/list', [StudentRegistrationController::class, 'studentData'])->name('madrashaDashboard.studentData');

    // API route for student stats (for dashboard)
    Route::get('/api/dashboard/student-stats', [StudentRegistrationController::class, 'studentStats'])->name('api.dashboard.student-stats');
});

// API route for user centers (dummy, returns empty for now)
Route::middleware('auth')->get('/api/user-centers', function() {
    return response()->json([]);
});




// Test routes for SessionYear functionality
Route::prefix('test-years')->group(function () {
    Route::get('/', [TestYearController::class, 'index'])->name('test.years.index');
    Route::get('/all', [TestYearController::class, 'getAllYears'])->name('test.years.all');
    Route::post('/convert', [TestYearController::class, 'convertYear'])->name('test.years.convert');
});

// Include other route files
require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';

require __DIR__ . '/Admin.php';
require __DIR__ . '/api.php';
