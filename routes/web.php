<?php
use App\Http\Controllers\MarhalaController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\SubjectSettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarhalaListController;
use Inertia\Inertia;
use App\Models\admin\marhala_for_admin\Marhala;
use App\Http\Controllers\ExamSetupController;


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
});

// মারহালা
Route::prefix('api')->group(function () {
    Route::get('/get-marhala-list', [MarhalaController::class, 'fetchMarhalaWithCounts']);
    Route::get('/subject-marhala-counts', [MarhalaController::class, 'getSubjectMarhalaStats']);
});






Route::get('Mrahala_for_Admin/marhala_edit/{marhala}', [MarhalaController::class, 'edit'])
    ->name('Mrahala_for_Admin.marhala_edit');

    Route::post('/subject-settings', [SubjectSettingsController::class, 'store'])
    ->name('subject-settings.store');


    Route::post('subject-settings/store', [SubjectSettingsController::class, 'store'])
    ->name('subject-settings.store');


    Route::get('/central-exam-setup/nibondon-setup/{id}', [ExamSetupController::class, 'nibondonSetup'])
    ->name('central_Exam_setup.nibondon_setup');





// সাবজেক্ট সেটিংস






    Route::get('/api/subject-settings/{id}', [MarhalaListController::class, 'getSubjectsettings'])->name('api.subject-settings');





    Route::get('/students-registration', [StudentRegistrationController::class, 'getStudentdata'])->name('students_registration.index');
    Route::get('/students-registration/{id}', [StudentRegistrationController::class, 'view'])->name('students_registration.stu_reg_view');




    Route::get('/madrasha/students/{madrasha_id}', [StudentRegistrationController::class, 'getMadrashaStudents'])
    ->name('nibondon_for_admin.madrashaWari_stu_nibond_list');

    Route::get('/nibondon/abandon-stu-list/{markaz_id}', [StudentRegistrationController::class, 'abandonStuList'])
    ->name('nibondon_for_admin.abandon_stu_list');



require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';


require __DIR__ . '/Madrasha.php';

require __DIR__ . '/Admin.php';
require __DIR__ . '/api.php';
