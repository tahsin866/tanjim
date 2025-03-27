<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\admin\marhala_for_admin\Marhala;
use App\Http\Controllers\ScheduleSetupController;
use App\Http\Controllers\MarhalaListController;
use App\Http\Controllers\MadrashaController;
use App\Http\Controllers\SubjectSettingsController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\ExamSetupController;
use App\Http\Controllers\MarkazAgreementController;
// মারহালা সেটাপ

Route::get('Mrahala_for_Admin/marhala_details_list', function () {
    return Inertia::render('Mrahala_for_Admin/marhala_details_list');
})->name('Mrahala_for_Admin.marhala_details_list');


Route::get('Mrahala_for_Admin/marhala_setup_list', function () {
    return Inertia::render('Mrahala_for_Admin/marhala_setup_list');
})->name('Mrahala_for_Admin.marhala_setup_list');

// Route::get('Mrahala_for_Admin/marhala_edit/{marhala}', function ($marhala) {
//     $marhalaData = Marhala::with('subjects')->findOrFail($marhala);

//     return Inertia::render('Mrahala_for_Admin/marhala_edit', [
//         'marhala' => $marhalaData
//     ]);
// })->name('Mrahala_for_Admin.marhala_edit');



// সাবজেক্ট সেটাপ


Route::get('subjects_for_Admin/subject_setup_list', function () {
    return Inertia::render('subjects_for_Admin/subject_setup_list');
})->name('subjects_for_Admin.subject_setup_list');


Route::get('subjects_for_Admin/subject_search_wizard', function () {
    return Inertia::render('subjects_for_Admin/subject_search_wizard');
})->name('subjects_for_Admin.subject_search_wizard');


Route::get('subjects_for_Admin/subject_setup', function () {
    return Inertia::render('subjects_for_Admin/subject_setup');
})->name('subjects_for_Admin.subject_setup');

Route::get('subjects_for_Admin/subject_setings_edit', function () {
    return Inertia::render('subjects_for_Admin/subject_setings_edit');
})->name('subjects_for_Admin.subject_setings_edit');
// কেন্দ্রীয় পরীক্ষা সেটাপ


Route::get('central_Exam_setup/central_exam_mng', function () {
    return Inertia::render('central_Exam_setup/central_exam_mng');
})->name('central_Exam_setup.central_exam_mng');


Route::get('central_Exam_setup/nibondon_setup', function () {
    return Inertia::render('central_Exam_setup/nibondon_setup');
})->name('central_Exam_setup.nibondon_setup');

Route::get('central_Exam_setup/ontorvukti_setup', function () {
    return Inertia::render('central_Exam_setup/ontorvukti_setup');
})->name('central_Exam_setup.ontorvukti_setup');

Route::get('central_Exam_setup/others_setup', function () {
    return Inertia::render('central_Exam_setup/others_setup');
})->name('central_Exam_setup.others_setup');

Route::get('central_Exam_setup/central_exam_name', function () {
    return Inertia::render('central_Exam_setup/central_exam_name');
})->name('central_Exam_setup.central_exam_name');

// Route::get('central_Exam_setup/central_exam_edit', function () {
//     return Inertia::render('central_Exam_setup/central_exam_edit');
// })->name('central_Exam_setup.central_exam_edit');


// নেগরান বিল


Route::get('Bill_setup_admin/negran_bill_setup', function () {
    return Inertia::render('Bill_setup_admin/negran_bill_setup');
})->name('Bill_setup_admin.negran_bill_setup');



Route::get('Bill_setup_admin/markaz_admin_bill', function () {
    return Inertia::render('Bill_setup_admin/markaz_admin_bill');
})->name('Bill_setup_admin.markaz_admin_bill');


Route::get('Bill_setup_admin/mumtahin_bill', function () {
    return Inertia::render('Bill_setup_admin/mumtahin_bill');
})->name('Bill_setup_admin.mumtahin_bill');


// marjaz_for_admin

Route::get('markaz_for_admin/markaz_setup', function () {
    return Inertia::render('markaz_for_admin/markaz_setup');
})->name('markaz_for_admin.markaz_setup');

Route::get('markaz_for_admin/all_markaz_list', function () {
    return Inertia::render('markaz_for_admin/all_markaz_list');
})->name('markaz_for_admin.all_markaz_list');

Route::get('markaz_for_admin/madrasha_list_underMarkaz', function () {
    return Inertia::render('markaz_for_admin/madrasha_list_underMarkaz');
})->name('markaz_for_admin.madrasha_list_underMarkaz');

// মাদরাসা ডাটা



Route::get('madrasha_data_for_admin/madrasha_list', function () {
    return Inertia::render('madrasha_data_for_admin/madrasha_list');
})->name('madrasha_data_for_admin.madrasha_list');


// নিবন্ধন লিস্ট

Route::get('nibondon_for_admin/nibondon_Markaz_list', function () {
    return Inertia::render('nibondon_for_admin/nibondon_Markaz_list');
})->name('nibondon_for_admin.nibondon_Markaz_list');

Route::get('nibondon_for_admin/abandon_stu_list', function () {
    return Inertia::render('nibondon_for_admin/abandon_stu_list');
})->name('nibondon_for_admin.abandon_stu_list');


Route::get('nibondon_for_admin/madrashaWari_stu_nibond_list', function () {
    return Inertia::render('nibondon_for_admin/madrashaWari_stu_nibond_list');
})->name('nibondon_for_admin.madrashaWari_stu_nibond_list');


Route::get('nibondon_for_admin/student_detiles_For_nibondon', function () {
    return Inertia::render('nibondon_for_admin/student_detiles_For_nibondon');
})->name('nibondon_for_admin.student_detiles_For_nibondon');



Route::get('user_create_for_admin/user_create', function () {
    return Inertia::render('user_create_for_admin/user_create');
})->name('user_create_for_admin.user_create');





Route::get('/subject-settings', [SubjectSettingsController::class, 'index'])->name('subject-settings.index');



// Route::get('/central-exam-setup/{id}/edit', [ExamSetupController::class, 'edit'])->name('central_Exam_setup.central_exam_edit');
// Route::put('/central-exam-setup/{id}', [ExamSetupController::class, 'update'])->name('central_Exam_setup.index');

    Route::get('/central-exam-setup/{id}/edit', [ExamSetupController::class, 'edit'])
        ->name('central_Exam_setup.central_exam_edit');

    // Route::put('/central-exam-setup/{id}', [ExamSetupController::class, 'update'])
    //     ->name('central_Exam_setup.update');

    // Route::get('/central-exam-setup', [ExamSetupController::class, 'index'])
    //     ->name('central_Exam_setup.index');

    Route::get('/markaz_for_admin/markaz_apply_details_view/{id}', [MarkazAgreementController::class, 'viewDetails_for_admin'])->name('AdminMarkaz.view');


    Route::post('/markaz/approve/{id}', [MarkazAgreementController::class, 'approveApplication'])->name('markaz.approve');
    Route::post('/markaz/reject/{id}', [MarkazAgreementController::class, 'return'])->name('markaz.reject');



    Route::get('/schedule-setups', [ScheduleSetupController::class, 'index'])->name('schedule-setups.index');
    Route::post('/schedule-setups', [ScheduleSetupController::class, 'store'])->name('schedule-setups.store');



    // Route::get('/madrashas/search', [MadrashaController::class, 'search'])->name('madrashas.search');
    Route::controller(MadrashaController::class)->group(function () {

        Route::post('/madrasah-search', 'search')->name('admin.madrasah.search');
        Route::get('/districts/{division}', 'getDistricts')->name('admin.locations.districts');
        Route::get('/thanas/{district}', 'getThanas')->name('admin.locations.thanas');
    });


    // Route::get('/exam-fees', [ExamRegistrationController::class, 'examFeeList'])->name('exam.fees.list');



    Route::post('/save-subject-selection', [MarhalaListController::class, 'saveSubjectSelection'])->name('api.save-subject-selection');



    // Route::get('/madrasha/{madrasha_id}/students', [StudentRegistrationController::class, 'getMadrashaStudents'])
    // ->name('nibondon_for_admin.madrashaWari_stu_nibond_list');

    Route::get('/markaz/{id}/madrashas', [MadrashaController::class, 'madrashaListUnderMarkaz'])
    ->name('markaz_for_admin.madrasha_list_underMarkaz');

    Route::get('/nibondon/madrashaWari-stu-nibond-list/{madrasha_id?}', [StudentRegistrationController::class, 'madrashaWariStuNibondList'])
    ->name('nibondon_for_admin.madrashaWari_stu_nibond_list');

// Route::get('/nibondon/student-detiles-for-nibondon/{student_id?}', [StudentRegistrationController::class, 'studentDetilesForNibondon'])
//     ->name('nibondon_for_admin.student_detiles_For_nibondon');
