<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\admin\marhala_for_admin\Marhala;
use App\Http\Controllers\ScheduleSetupController;
use App\Http\Controllers\MarhalaListController;
use App\Http\Controllers\MadrashaController;
use App\Http\Controllers\MarhalaController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\Admin\auth\AdminRegisteredUserController;
use App\Http\Controllers\ExamSetupController;
use App\Http\Controllers\MarkazAgreementController;

// ============= মারহালা সেটাপ =============
Route::get('/marhala-details-list', function () {
    return Inertia::render('Mrahala_for_Admin/marhala_details_list');
})->name('Mrahala_for_Admin.marhala_details_list');

Route::get('/marhala-setup-list', function () {
    return Inertia::render('Mrahala_for_Admin/marhala_setup_list');
})->name('Mrahala_for_Admin.marhala_setup_list');

// Route::get('Mrahala_for_Admin/marhala_edit/{marhala}', function ($marhala) {
//     $marhalaData = Marhala::with('subjects')->findOrFail($marhala);
//     return Inertia::render('Mrahala_for_Admin/marhala_edit', [
//         'marhala' => $marhalaData
//     ]);
// })->name('Mrahala_for_Admin.marhala_edit');

Route::get('/marhala-edit/{marhala}', [MarhalaController::class, 'edit'])
    ->name('Mrahala_for_Admin.marhala_edit');

// ============= সাবজেক্ট সেটাপ =============
Route::get('/subject-setup-list', function () {
    return Inertia::render('subjects_for_Admin/subject_setup_list');
})->name('subjects_for_Admin.subject_setup_list');

Route::get('/subject-search-wizard', function () {
    return Inertia::render('subjects_for_Admin/subject_search_wizard');
})->name('subjects_for_Admin.subject_search_wizard');

Route::get('/subject-setup', function () {
    return Inertia::render('subjects_for_Admin/subject_setup');
})->name('subjects_for_Admin.subject_setup');

Route::get('/subject-setings-edit', function () {
    return Inertia::render('subjects_for_Admin/subject_setings_edit');
})->name('subjects_for_Admin.subject_setings_edit');

// ============= কেন্দ্রীয় পরীক্ষা সেটাপ =============
Route::get('/central-exam-mng', function () {
    return Inertia::render('central_Exam_setup/central_exam_mng');
})->name('central_Exam_setup.central_exam_mng');

Route::get('/nibondon-setup', function () {
    return Inertia::render('central_Exam_setup/nibondon_setup');
})->name('central_Exam_setup.nibondon_setup');

Route::get('/ontorvukti-setup', function () {
    return Inertia::render('central_Exam_setup/ontorvukti_setup');
})->name('central_Exam_setup.ontorvukti_setup');

Route::get('/others-setup', function () {
    return Inertia::render('central_Exam_setup/others_setup');
})->name('central_Exam_setup.others_setup');

Route::get('/central-exam-name', function () {
    return Inertia::render('central_Exam_setup/central_exam_name');
})->name('central_Exam_setup.central_exam_name');

Route::get('/central-name-eidt', function () {
    return Inertia::render('central_Exam_setup/central_name_eidt');
})->name('central_Exam_setup.central_name_eidt');

Route::get('/others-setup-edit', function () {
    return Inertia::render('central_Exam_setup/others_setup_edit');
})->name('central_Exam_setup.others_setup_edit');

// ============= নেগরান বিল =============
Route::get('Bill_setup_admin/negran_bill_setup', function () {
    return Inertia::render('Bill_setup_admin/negran_bill_setup');
})->name('Bill_setup_admin.negran_bill_setup');

Route::get('Bill_setup_admin/markaz_admin_bill', function () {
    return Inertia::render('Bill_setup_admin/markaz_admin_bill');
})->name('Bill_setup_admin.markaz_admin_bill');

Route::get('Bill_setup_admin/mumtahin_bill', function () {
    return Inertia::render('Bill_setup_admin/mumtahin_bill');
})->name('Bill_setup_admin.mumtahin_bill');

// ============= মারকাজ ফর অ্যাডমিন =============
Route::get('/markaz-setup', function () {
    return Inertia::render('markaz_for_admin/markaz_setup');
})->name('markaz_for_admin.markaz_setup');

Route::get('/all-markaz-list', function () {
    return Inertia::render('markaz_for_admin/all_markaz_list');
})->name('markaz_for_admin.all_markaz_list');

Route::get('/madrasha-list-underMarkaz', function () {
    return Inertia::render('markaz_for_admin/madrasha_list_underMarkaz');
})->name('markaz_for_admin.madrasha_list_underMarkaz');

Route::get('/markaz-change-apply-list', function () {
    return Inertia::render('markaz_for_admin/markaz_change_apply_list');
})->name('markaz_for_admin.markaz_change_apply_list');

// ============= মাদরাসা ডাটা =============
Route::get('/madrasha_list', function () {
    return Inertia::render('madrasha_data_for_admin/madrasha_list');
})->name('madrasha_data_for_admin.madrasha_list');

// ============= নিবন্ধন লিস্ট =============
Route::get('/nibondon-markaz-list', function () {
    return Inertia::render('nibondon_for_admin/nibondon_Markaz_list');
})->name('nibondon_for_admin.nibondon_Markaz_list');

Route::get('/abandon-stu-list', function () {
    return Inertia::render('nibondon_for_admin/abandon_stu_list');
})->name('nibondon_for_admin.abandon_stu_list');

Route::get('nibondon_for_admin/madrashaWari_stu_nibond_list', function () {
    return Inertia::render('nibondon_for_admin/madrashaWari_stu_nibond_list');
})->name('nibondon_for_admin.madrashaWari_stu_nibond_list');

Route::get('nibondon_for_admin/student_detiles_For_nibondon', function () {
    return Inertia::render('nibondon_for_admin/student_detiles_For_nibondon');
})->name('nibondon_for_admin.student_detiles_For_nibondon');

// ============= ইউজার ম্যানেজমেন্ট =============
Route::get('user_create_for_admin/user_create_for_admin', function () {
    return Inertia::render('user_create_for_admin/user_create_for_admin');
})->name('user_create_for_admin.user_create_for_admin');

Route::get('/new-user-for-admin', function () {
    return Inertia::render('user_create_for_admin/new_user_for_admin');
})->name('user_create_for_admin.new_user_for_admin');

Route::get('user_create_for_admin/admin_user_edit', function () {
    return Inertia::render('user_create_for_admin/admin_user_edit');
})->name('user_create_for_admin.admin_user_edit');

// ============= কন্ট্রোলার বেইজড রাউট =============

// ExamSetupController
// Route::get('/subject-settings', [SubjectSettingsController::class, 'index'])->name('subject-settings.index');
// Route::get('/central-exam-setup/{id}/edit', [ExamSetupController::class, 'edit'])->name('central_Exam_setup.central_exam_edit');
// Route::put('/central-exam-setup/{id}', [ExamSetupController::class, 'update'])->name('central_Exam_setup.index');
Route::get('/central-exam-setup/{id}/edit', [ExamSetupController::class, 'edit'])
    ->name('central_Exam_setup.central_exam_edit');
// Route::put('/central-exam-setup/{id}', [ExamSetupController::class, 'update'])
//     ->name('central_Exam_setup.update');
// Route::get('/central-exam-setup', [ExamSetupController::class, 'index'])
//     ->name('central_Exam_setup.index');

// MarkazAgreementController
Route::get('/markaz-apply-details-view/{id}', [MarkazAgreementController::class, 'viewDetails_for_admin'])->name('AdminMarkaz.view');
Route::post('/markaz/approve/{id}', [MarkazAgreementController::class, 'approveApplication'])->name('markaz.approve');
Route::post('/markaz/reject/{id}', [MarkazAgreementController::class, 'return'])->name('markaz.reject');

// ScheduleSetupController
Route::get('/schedule-setups', [ScheduleSetupController::class, 'index'])->name('schedule-setups.index');
Route::post('/schedule-setups', [ScheduleSetupController::class, 'store'])->name('schedule-setups.store');

// MadrashaController
// Route::get('/madrashas/search', [MadrashaController::class, 'search'])->name('madrashas.search');
Route::controller(MadrashaController::class)->group(function () {
    Route::post('/madrasah-search', 'search')->name('admin.madrasah.search');
    Route::get('/districts/{division}', 'getDistricts')->name('admin.locations.districts');
    Route::get('/thanas/{district}', 'getThanas')->name('admin.locations.thanas');
});
Route::get('/markaz/{id}/madrashas', [MadrashaController::class, 'madrashaListUnderMarkaz'])
    ->name('markaz_for_admin.madrasha_list_underMarkaz');

// MarhalaListController
Route::post('/save-subject-selection', [MarhalaListController::class, 'saveSubjectSelection'])->name('api.save-subject-selection');

// StudentRegistrationController
// Route::get('/exam-fees', [ExamRegistrationController::class, 'examFeeList'])->name('exam.fees.list');
// Route::get('/madrasha/{madrasha_id}/students', [StudentRegistrationController::class, 'getMadrashaStudents'])
// ->name('nibondon_for_admin.madrashaWari_stu_nibond_list');
Route::get('/madrashaWari-stu-nibond-list/{madrasha_id?}', [StudentRegistrationController::class, 'madrashaWariStuNibondList'])
    ->name('nibondon_for_admin.madrashaWari_stu_nibond_list');
Route::get('/students/registration-forAdmin/{id}', [StudentRegistrationController::class, 'AdminstudentRegistrationView'])
    ->name('nibondon_for_admin.student_detiles_For_nibondon');
Route::post('/student/approve/{id}', [StudentRegistrationController::class, 'StuApproveApplication'])->name('student.approve');
Route::post('/student/reject/{id}', [StudentRegistrationController::class, 'studentReturn'])->name('student.return');

// AdminRegisteredUserController
Route::get('/user-create-for-admin', [AdminRegisteredUserController::class, 'create'])->name('user_create_for_admin.user_create_for_admin');
Route::post('/user-create-for-admin', [AdminRegisteredUserController::class, 'store'])->name('user_create_for_admin.store');
Route::get('/admin/users/{id}/edit', [AdminRegisteredUserController::class, 'adminEdit'])->name('user_create_for_admin.admin_user_edit');
Route::put('/admin/users/{id}', [AdminRegisteredUserController::class, 'adminUpdate'])->name('user_create_for_admin.update');
Route::delete('/admin/users/{id}', [AdminRegisteredUserController::class, 'adminDestroy'])->name('user_create_for_admin.destroy');
