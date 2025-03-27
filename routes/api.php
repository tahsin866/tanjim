<?php

use App\Http\Controllers\MarhalaController;
use App\Http\Controllers\SubjectSettingsController;
use App\Http\Controllers\ExamSetupController;
use App\Http\Controllers\ScheduleSetupController;
use App\Http\Controllers\ExamRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkazAgreementController;
use App\Http\Controllers\MadrashaController;
use App\Http\Controllers\MarhalaListController;
use App\Http\Controllers\StudentRegistrationController;



Route::get('/marhalas/{id}/edit', [MarhalaController::class, 'edit']);
Route::put('/marhalas/{id}', [MarhalaController::class, 'update']);

Route::prefix('api')->group(function () {
    Route::get('/marhala/{marhala}/subjects', [SubjectSettingsController::class, 'getData']);

    Route::get('/subjects', [SubjectSettingsController::class, 'index']);
    Route::post('/subject-settings', [SubjectSettingsController::class, 'store'])->name('subject-settings.store');
    Route::get('/subjects', [SubjectSettingsController::class, 'search']);
    Route::post('/exam-setups', [SubjectSettingsController::class, 'store_1']);

    Route::get('/exam-setups/latest', [SubjectSettingsController::class, 'getLatest']);
    Route::get('/marhalas', [SubjectSettingsController::class, 'index_1']);

    Route::post('/exam-fees', [SubjectSettingsController::class, 'store_2']);

    Route::get('/exam-setups_1', [ExamSetupController::class, 'index_2']);

    Route::put('/central-exam-setup/{id}', [ExamSetupController::class, 'update'])
        ->name('central_Exam_setup.update');

    Route::get('/central-exam-setup', [ExamSetupController::class, 'index'])
        ->name('central_Exam_setup.index');




    Route::get('/madrashas/list', [MarkazAgreementController::class, 'getMadrashas'])->name('madrashas.list');
    // Route::get('/exam-setups/latest', [MarkazAgreementController::class, 'getLatest'])->name('exam-setups.latest');
    Route::get('/markaz/get-table-data', [MarkazAgreementController::class, 'getTableData']);



    Route::get('/markaz-agreements', [MarkazAgreementController::class, 'fatch']);
// Route::get('/markaz-agreement-madrasas/counts', [MarkazAgreementController::class, 'getMadrasaCounts']);




Route::get('/markaz-madrashas/list', [MarkazAgreementController::class, 'getMadrashas'])->name('markaz.madrashas.list');




Route::post('/schedule-setups', [ScheduleSetupController::class, 'store']);



Route::get('/madrasha-list', [MadrashaController::class, 'getMadrashaList']);

Route::get('/markaz-list', [MadrashaController::class, 'getMarkazList']);
// এডমিনের মারকায ফিল্টার
Route::get('/madrashas/filter', [MadrashaController::class, 'filterMadrashas']);

// Route::get('/markaz/{id}/madrashas', [MadrashaController::class, 'getMadrashasUnderMarkaz'])
//     ->name('markaz_for_admin.madrasha_list_underMarkaz');



Route::get('/madrasa-list', [MadrashaController::class, 'index']);
Route::get('/divisions', [MadrashaController::class, 'getDivisions']);
Route::get('/districts/{division}', [MadrashaController::class, 'getDistricts']);
Route::get('/thanas/{district}', [MadrashaController::class, 'getThanas']);
Route::get('/export-madrasa', [MadrashaController::class, 'export']);


Route::get('/exam-fees', [ExamRegistrationController::class, 'examFeeList']);


Route::get('/student-registration/{marhalaId}', [ExamRegistrationController::class, 'getRegistrationData']);
Route::get('/student-years', [ExamRegistrationController::class, 'getStudentYears']);
Route::get('/search-students', [ExamRegistrationController::class, 'searchStudents']);


Route::get('/get-student-for-edit', [ExamRegistrationController::class, 'getStudentForEdit']);





Route::post('/save-student-info', [ExamRegistrationController::class, 'saveStudentInfo']);

Route::post('/save-student-info_1/{marhalaId}', [ExamRegistrationController::class, 'NewSaveStudentInfo']);





// মাদরাসা পেনেলের সাবজেক্ট সেটিংস

Route::get('/subjects/{marhalaId}', [MarhalaListController::class, 'getSubjects'])->name('api.subjects');


Route::post('/save-subject-selection', [MarhalaListController::class, 'saveSubjectSelection'])->name('api.save-subject-selection');

Route::get('/user-subject-selection/{marhalaId}', [MarhalaListController::class, 'getUserSubjectSelection']);



Route::get('/students-registration', [StudentRegistrationController::class, 'getStudents']);




Route::get('/markaz-students', [StudentRegistrationController::class, 'getMarkazStudents']);


Route::get('/markaz-madrasa-list/{markaz_id}', [StudentRegistrationController::class, 'getMarkazMadrasaList'])
    ->name('api.markaz_madrasa_list');



    Route::get('/nibondon/abandon-stu-list/{markaz_id}', [StudentRegistrationController::class, 'abandonStuList'])
    ->name('nibondon_for_admin.abandon_stu_list');



    // Route::get('/madrasha/students/{madrasha_id}', [StudentRegistrationController::class, 'getMadrashaStudents'])
    // ->name('api.madrasha_students');







});
