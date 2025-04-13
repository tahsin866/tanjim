<?php

namespace App\Http\Controllers\Admin\auth;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\admin_permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $admin->profile_image = $path;
            $admin->save();
        }



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







    public function adminEdit($id)
    {
        // Get admin data
        $admin = Admin::findOrFail($id);

        // Get permissions data
        $permissions = admin_permission::where('admin_id', $id)->first();

        return Inertia::render('user_create_for_admin/admin_user_edit', [
            'admin' => $admin,
            'permissions' => $permissions
        ]);
    }

    public function adminUpdate(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        // Validate admin data
        $validatedAdmin = $request->validate([
            'name' => '|string|max:255',
            'email' => '|string|email|max:255|unique:admins,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'nid' => 'nullable|string|max:50',
            'brn' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'designation' => '|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // Handle profile image upload if provided
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($admin->profile_image) {
                Storage::delete('public/' . $admin->profile_image);
            }

            $path = $request->file('profile_image')->store('profile-images', 'public');
            $validatedAdmin['profile_image'] = $path;
        }

        // Update admin data
        $admin->update($validatedAdmin);

        // Validate permissions data
        $validatedPermissions = $request->validate([
            'setup_access' => 'boolean',
            'marhala_setup' => 'boolean',
            'subject_setup' => 'boolean',
            'central_exam_setup' => 'boolean',
            'user_setup' => 'boolean',
            'instruction' => 'boolean',
            'bill_access' => 'boolean',
            'negran_bill' => 'boolean',
            'mumtahin_bill' => 'boolean',
            'markaz_admin_bill' => 'boolean',
            'zonal_bill' => 'boolean',
            'madrasa_access' => 'boolean',
            'madrasa_list' => 'boolean',
            'madrasa_misc' => 'boolean',
            'madrasa_admin' => 'boolean',
            'draft_soft_delete' => 'boolean',
            'madrasa_payment' => 'boolean',
            'markaz_access' => 'boolean',
            'markaz_application_list' => 'boolean',
            'proposed_markaz' => 'boolean',
            'markaz_list' => 'boolean',
            'markaz_change_application' => 'boolean',
            'markaz_admin' => 'boolean',
            'markaz_admin_training' => 'boolean',
            'markaz_group' => 'boolean',
            'answer_sheet_group_setup' => 'boolean',
            'mumtahin_group' => 'boolean',
            'exam_routine_access' => 'boolean',
            'exam_routine_group' => 'boolean',
            'exam_routine' => 'boolean',
            'oral_exam_mumtahin' => 'boolean',
            'registration_access' => 'boolean',
            'madrasa_list_reg' => 'boolean',
            'registration_list' => 'boolean',
            'cancelled_registration_list' => 'boolean',
            'payment_list' => 'boolean',
            'board_return_list' => 'boolean',
            'registration_card_create' => 'boolean',
            'inclusion_access' => 'boolean',
            'inclusion_list' => 'boolean',
            'roll_generate' => 'boolean',
            'admit_card_create' => 'boolean',
            'inclusion_payment' => 'boolean',
            'cancelled_inclusion_list' => 'boolean',
            'khata_loose_access' => 'boolean',
            'khata_loose_setup' => 'boolean',
            'khata_loose_generate' => 'boolean',
            'khata_loose_account' => 'boolean',
            'khata_loose_others' => 'boolean',
            'negran_access' => 'boolean',
            'negran_application_list' => 'boolean',
            'negran_proposed_list' => 'boolean',
            'negran_pending_list' => 'boolean',
            'negran_cancelled_list' => 'boolean',
            'negran_mumtahin_list' => 'boolean',
            'negran_report' => 'boolean',
            'negran_allowance' => 'boolean',
            'mumtahin_access' => 'boolean',
            'mumtahin_application_list' => 'boolean',
            'mumtahin_proposed_list' => 'boolean',
            'inspector_setup' => 'boolean',
            'mumtahin_list' => 'boolean',
            'darsiyat_mumtahin' => 'boolean',
            'hifz_mumtahin_selection' => 'boolean',
            'kirat_mumtahin_selection' => 'boolean',
            'mumtahin_training' => 'boolean',
            'zone_access' => 'boolean',
            'zone_setup' => 'boolean',
            'zonal_selection' => 'boolean',
            'sub_zone_setup' => 'boolean',
            'zone_wise_markaz_setup' => 'boolean',
            'attendance_access' => 'boolean',
            'examinee_attendance' => 'boolean',
            'negran_attendance' => 'boolean',
            'result_access' => 'boolean',
            'result_condition' => 'boolean',
            'merit_condition' => 'boolean',
            'inspection_formula' => 'boolean',
            'darsiyat_result' => 'boolean',
            'oral_result' => 'boolean',
            'result_correction' => 'boolean',
            'result_review' => 'boolean',
            'review_result_correction' => 'boolean',
            'messaging' => 'boolean',
            'notice' => 'boolean',
        ]);

        // Update or create permissions
        admin_permission::updateOrCreate(
            ['admin_id' => $id],
            $validatedPermissions
        );

        return back()->with('success', 'Admin user updated successfully');

    }





    public function adminDestroy($id)
    {
        try {
            // প্রথমে এডমিন আইডি দিয়ে এডমিন খুঁজে বের করি
            $admin = Admin::findOrFail($id);

            // এডমিন পারমিশন ডিলিট করি
            // এখানে আমরা ম্যানুয়ালি ডিলিট করছি, কিন্তু আপনি মডেলে cascade ডিলিট সেট করতে পারেন
            admin_permission::where('admin_id', $id)->delete();

            // এডমিন ডিলিট করি
            $admin->delete();

            return redirect()->route('user_create_for_admin.index')
                ->with('success', 'এডমিন সফলভাবে মুছে ফেলা হয়েছে।');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'এডমিন মুছে ফেলতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }












}
