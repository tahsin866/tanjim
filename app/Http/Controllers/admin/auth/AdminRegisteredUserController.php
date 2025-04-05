<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\admin_permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class AdminRegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('user_create_for_admin/user_create_for_admin');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.admin::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create admin user
        $admin = admin::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'profile_image' => $request->profile_image,
            'nid' => $request->nid,
            'brn' => $request->brn,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create permissions in admin_permissions table
        $permissionData = [
            'admin_id' => $admin->id,
            'setup_access' => $request->setup_access ? 1 : 0,
            'marhala_setup' => $request->marhala_setup ? 1 : 0,
            'subject_setup' => $request->subject_setup ? 1 : 0,
            'central_exam_setup' => $request->central_exam_setup ? 1 : 0,
            'user_setup' => $request->user_setup ? 1 : 0,
            'instruction' => $request->instruction ? 1 : 0,
            'bill_access' => $request->bill_access ? 1 : 0,
            'negran_bill' => $request->negran_bill ? 1 : 0,
            'mumtahin_bill' => $request->mumtahin_bill ? 1 : 0,
            'markaz_admin_bill' => $request->markaz_admin_bill ? 1 : 0,
            'zonal_bill' => $request->zonal_bill ? 1 : 0,
            'madrasa_access' => $request->madrasa_access ? 1 : 0,
            'madrasa_list' => $request->madrasa_list ? 1 : 0,
            'madrasa_misc' => $request->madrasa_misc ? 1 : 0,
            'madrasa_admin' => $request->madrasa_admin ? 1 : 0,
            'draft_soft_delete' => $request->draft_soft_delete ? 1 : 0,
            'madrasa_payment' => $request->madrasa_payment ? 1 : 0,
            'markaz_access' => $request->markaz_access ? 1 : 0,
            'markaz_application_list' => $request->markaz_application_list ? 1 : 0,
            'proposed_markaz' => $request->proposed_markaz ? 1 : 0,
            'markaz_list' => $request->markaz_list ? 1 : 0,
            'markaz_change_application' => $request->markaz_change_application ? 1 : 0,
            'markaz_admin' => $request->markaz_admin ? 1 : 0,
            'markaz_admin_training' => $request->markaz_admin_training ? 1 : 0,
            'markaz_group' => $request->markaz_group ? 1 : 0,
            'answer_sheet_group_setup' => $request->answer_sheet_group_setup ? 1 : 0,
            'mumtahin_group' => $request->mumtahin_group ? 1 : 0,
            'exam_routine_access' => $request->exam_routine_access ? 1 : 0,
            'exam_routine_group' => $request->exam_routine_group ? 1 : 0,
            'exam_routine' => $request->exam_routine ? 1 : 0,
            'oral_exam_mumtahin' => $request->oral_exam_mumtahin ? 1 : 0,
            'registration_access' => $request->registration_access ? 1 : 0,
            'madrasa_list_reg' => $request->madrasa_list_reg ? 1 : 0,
            'registration_list' => $request->registration_list ? 1 : 0,
            'cancelled_registration_list' => $request->cancelled_registration_list ? 1 : 0,
            'payment_list' => $request->payment_list ? 1 : 0,
            'board_return_list' => $request->board_return_list ? 1 : 0,
            'registration_card_create' => $request->registration_card_create ? 1 : 0,
            'inclusion_access' => $request->inclusion_access ? 1 : 0,
            'inclusion_list' => $request->inclusion_list ? 1 : 0,
            'roll_generate' => $request->roll_generate ? 1 : 0,
            'admit_card_create' => $request->admit_card_create ? 1 : 0,
            'inclusion_payment' => $request->inclusion_payment ? 1 : 0,
            'cancelled_inclusion_list' => $request->cancelled_inclusion_list ? 1 : 0,
            'khata_loose_access' => $request->khata_loose_access ? 1 : 0,
            'khata_loose_setup' => $request->khata_loose_setup ? 1 : 0,
            'khata_loose_generate' => $request->khata_loose_generate ? 1 : 0,
            'khata_loose_account' => $request->khata_loose_account ? 1 : 0,
            'khata_loose_others' => $request->khata_loose_others ? 1 : 0,
            'negran_access' => $request->negran_access ? 1 : 0,
            'negran_application_list' => $request->negran_application_list ? 1 : 0,
            'negran_proposed_list' => $request->negran_proposed_list ? 1 : 0,
            'negran_pending_list' => $request->negran_pending_list ? 1 : 0,
            'negran_cancelled_list' => $request->negran_cancelled_list ? 1 : 0,
            'negran_mumtahin_list' => $request->negran_mumtahin_list ? 1 : 0,
            'negran_report' => $request->negran_report ? 1 : 0,
            'negran_allowance' => $request->negran_allowance ? 1 : 0,
            'mumtahin_access' => $request->mumtahin_access ? 1 : 0,
            'mumtahin_application_list' => $request->mumtahin_application_list ? 1 : 0,
            'mumtahin_proposed_list' => $request->mumtahin_proposed_list ? 1 : 0,
            'inspector_setup' => $request->inspector_setup ? 1 : 0,
            'mumtahin_list' => $request->mumtahin_list ? 1 : 0,
            'darsiyat_mumtahin' => $request->darsiyat_mumtahin ? 1 : 0,
            'hifz_mumtahin_selection' => $request->hifz_mumtahin_selection ? 1 : 0,
            'kirat_mumtahin_selection' => $request->kirat_mumtahin_selection ? 1 : 0,
            'mumtahin_training' => $request->mumtahin_training ? 1 : 0,
            'zone_access' => $request->zone_access ? 1 : 0,
            'zone_setup' => $request->zone_setup ? 1 : 0,
            'zonal_selection' => $request->zonal_selection ? 1 : 0,
            'sub_zone_setup' => $request->sub_zone_setup ? 1 : 0,
            'zone_wise_markaz_setup' => $request->zone_wise_markaz_setup ? 1 : 0,
            'attendance_access' => $request->attendance_access ? 1 : 0,
            'examinee_attendance' => $request->examinee_attendance ? 1 : 0,
            'negran_attendance' => $request->negran_attendance ? 1 : 0,
            'result_access' => $request->result_access ? 1 : 0,
            'result_condition' => $request->result_condition ? 1 : 0,
            'merit_condition' => $request->merit_condition ? 1 : 0,
            'inspection_formula' => $request->inspection_formula ? 1 : 0,
            'darsiyat_result' => $request->darsiyat_result ? 1 : 0,
            'oral_result' => $request->oral_result ? 1 : 0,
            'result_correction' => $request->result_correction ? 1 : 0,
            'result_review' => $request->result_review ? 1 : 0,
            'review_result_correction' => $request->review_result_correction ? 1 : 0,
            'messaging' => $request->messaging ? 1 : 0,
            'notice' => $request->notice ? 1 : 0,
        ];

        admin_permission::create($permissionData);

        // সফল রেজিস্ট্রেশন মেসেজ সহ রেজিস্ট্রেশন পেজে ফিরে যাওয়া
        return redirect()->route('user_create_for_admin.user_create_for_admin')->with('success', 'অ্যাডমিন সফলভাবে তৈরি করা হয়েছে।');
    }
}
