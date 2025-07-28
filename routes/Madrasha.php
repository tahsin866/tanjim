<?php

use App\Http\Controllers\MarhalaController;
use App\Http\Controllers\ExamRegistrationController;
use App\Http\Controllers\MarkazAgreementController;

use App\Http\Controllers\StudentRegistrationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;




Route::get('/Studen/list', [StudentRegistrationController::class, 'studentData'])
->name('madrashaDashboard.studentData');

Route::put('/students/{id}', [StudentRegistrationController::class, 'updateStudent'])->name('students.update');

Route::get('Auth/madrasha_check_for_user', function () {
    return Inertia::render('Auth/madrasha_check_for_user');
})->name('Auth.madrasha_check_for_user');

Route::get('/marhalas', [MarhalaController::class, 'index'])->name('marhalas.index');
Route::post('/marhalas', [MarhalaController::class, 'store'])->name('marhalas.store');

Route::get('/marhalas/{id}/edit', [MarhalaController::class, 'edit'])->name('marhalas.edit');
Route::put('/marhalas/{id}', [MarhalaController::class, 'update'])->name('marhalas.update');

// Route::get('/Mrahala_for_Admin/marhala_details_list', [MarhalaListController::class, 'marhalaList'])
// ->name('Mrahala_for_Admin.marhala_details_list');





// Route::get('/student-registration/edit', [ExamRegistrationController::class, 'editStudentRegistration'])
// ->name('students_registration.old_stu_reg_edit');
Route::get('/students/registration/edit', [ExamRegistrationController::class, 'editStudentRegistration'])
    ->name('students_registration.old_stu_reg_edit');


// Add this route to fetch student data for editing
Route::get('/get-student-for-edit', [ExamRegistrationController::class, 'getStudentForEdit']);

// Add this route to update student data



// Route::get('/Dashboard', [dashboardController::class, 'dashboard'])->name('Dashboard');

