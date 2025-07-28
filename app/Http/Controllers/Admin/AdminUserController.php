<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index(): Response
    {
        $admins = Admin::orderBy('created_at', 'desc')->get();

        return Inertia::render('admin/AdminUsers/Index', [
            'admins' => $admins
        ]);
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create(): Response
    {
        // Graduation years from user_informations table (not users)
        $takmilyears = UserInformation::whereNotNull('dept_takmil_year_english')->distinct()->pluck('dept_takmil_year_english');
        $iftayears = UserInformation::whereNotNull('dept_ifta_year_english')->distinct()->pluck('dept_ifta_year_english');
        $hifzyears = UserInformation::whereNotNull('dept_hifz_year_english')->distinct()->pluck('dept_hifz_year_english');
        $qiratyears = UserInformation::whereNotNull('dept_qirat_year_english')->distinct()->pluck('dept_qirat_year_english');
        $graduationYears = $takmilyears->merge($iftayears)->merge($hifzyears)->merge($qiratyears)->unique()->sort()->values();

        // Available permissions structure
        $availablePermissions = $this->getAvailablePermissions();

        return Inertia::render('admin/AdminUsers/Create', [
            'graduationYears' => $graduationYears,
            'availablePermissions' => $availablePermissions
        ]);
    }

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        $admin = $this->createAdmin($request->all());

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user created successfully!');
    }

    /**
     * Show the form for editing an admin user.
     */
    public function edit($id): Response
    {
        $admin = Admin::findOrFail($id);

        $takmilyears = UserInformation::whereNotNull('dept_takmil_year_english')->distinct()->pluck('dept_takmil_year_english');
        $iftayears = UserInformation::whereNotNull('dept_ifta_year_english')->distinct()->pluck('dept_ifta_year_english');
        $hifzyears = UserInformation::whereNotNull('dept_hifz_year_english')->distinct()->pluck('dept_hifz_year_english');
        $qiratyears = UserInformation::whereNotNull('dept_qirat_year_english')->distinct()->pluck('dept_qirat_year_english');
        $graduationYears = $takmilyears->merge($iftayears)->merge($hifzyears)->merge($qiratyears)->unique()->sort()->values();

        // Available permissions structure
        $availablePermissions = $this->getAvailablePermissions();

        return Inertia::render('admin/AdminUsers/Edit', [
            'admin' => $admin->toArray(),
            'graduationYears' => $graduationYears,
            'availablePermissions' => $availablePermissions
        ]);
    }

    /**
     * Update the specified admin user.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);
        $this->updateValidator($request->all(), $admin->id)->validate();

        // Prepare update data
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'designation' => $request->designation,
            'phone' => $request->phone,
            'graduation_year' => $request->graduation_year,
            'permissions' => $request->permissions ?? [],
            'updated_by' => Auth::guard('admin')->id(),
        ];

        // Only allow role and is_active changes if not super_admin
        if ($admin->role !== 'super_admin') {
            $updateData['role'] = $request->role;
            $updateData['is_active'] = $request->boolean('is_active');
        }

        $admin->update($updateData);

        if ($request->filled('password')) {
            $admin->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user updated successfully!');
    }

    /**
     * Remove the specified admin user.
     */
    public function destroy($id): RedirectResponse
    {
        $admin = Admin::findOrFail($id);

        if ($admin->role === 'super_admin') {
            return back()->withErrors(['error' => 'Cannot delete super admin!']);
        }

        $admin->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully!');
    }

    /**
     * Get a validator for an incoming admin creation request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,moderator'],
            'department' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'graduation_year' => ['nullable', 'numeric', 'min:1900', 'max:2099'],
            'permissions' => ['nullable', 'array'],
            'is_active' => ['boolean'],
        ]);
    }

    /**
     * Get a validator for an incoming admin update request.
     */
    protected function updateValidator(array $data, $adminId)
    {
        $admin = Admin::find($adminId);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $adminId],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'department' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'graduation_year' => ['nullable', 'numeric', 'min:1900', 'max:2099'],
            'permissions' => ['nullable', 'array'],
        ];

        // Only validate role and is_active if not super_admin
        if ($admin && $admin->role !== 'super_admin') {
            $rules['role'] = ['required', 'string', 'in:admin,moderator'];
            $rules['is_active'] = ['boolean'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new admin instance.
     */
    protected function createAdmin(array $data): Admin
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'department' => $data['department'] ?? null,
            'designation' => $data['designation'] ?? null,
            'phone' => $data['phone'] ?? null,
            'graduation_year' => $data['graduation_year'] ?? null,
            'permissions' => $data['permissions'] ?? [],
            'is_active' => $data['is_active'] ?? true,
            'created_by' => Auth::guard('admin')->id() ?: null,
        ]);
    }

    /**
     * Get available permissions structure for admin creation/editing
     */
    protected function getAvailablePermissions(): array
    {
        return [
            'messaging' => [
                'name' => 'মেসেজিং',
                'permissions' => [
                    'messaging_access' => 'মেসেজিং অ্যাক্সেস',
                    'messaging_send' => 'মেসেজ পাঠানো',
                    'messaging_delete' => 'মেসেজ মুছা',
                ]
            ],
            'notice' => [
                'name' => 'নোটিস',
                'permissions' => [
                    'notice_access' => 'নোটিস অ্যাক্সেস',
                    'notice_create' => 'নোটিস তৈরি',
                    'notice_edit' => 'নোটিস সম্পাদনা',
                    'notice_delete' => 'নোটিস মুছা',
                ]
            ],
            'document_management' => [
                'name' => 'দস্তরবন্দি ব্যবস্থাপনা',
                'permissions' => [
                    'document_management_access' => 'দস্তরবন্দি ব্যবস্থাপনা অ্যাক্সেস',
                    'document_application_list' => 'দস্তরবন্দি আবেদন তালিকা',
                    'document_approve' => 'দস্তরবন্দি অনুমোদন',
                    'document_reject' => 'দস্তরবন্দি বাতিল',
                    'document_suspend' => 'দস্তরবন্দি স্থগিত',
                    'document_delete' => 'দস্তরবন্দি মুছা',
                ]
            ],
            'application_management' => [
                'name' => 'আবেদন ব্যবস্থাপনা',
                'permissions' => [
                    'application_management_access' => 'আবেদন ব্যবস্থাপনা অ্যাক্সেস',
                    'application_list' => 'আবেদন তালিকা',
                    'application_view' => 'আবেদন দেখা',
                    'application_approve' => 'আবেদন অনুমোদন',
                    'application_reject' => 'আবেদন বাতিল',
                ]
            ],
            'grant_management' => [
                'name' => 'অনুদান ব্যবস্থাপনা',
                'permissions' => [
                    'grant_management_access' => 'অনুদান ব্যবস্থাপনা অ্যাক্সেস',
                    'grant_project_create' => 'অনুদান প্রজেক্ট তৈরি',
                    'grant_project_edit' => 'অনুদান প্রজেক্ট সম্পাদনা',
                    'grant_project_delete' => 'অনুদান প্রজেক্ট মুছা',
                    'grant_application_view' => 'অনুদান আবেদন দেখা',
                    'grant_application_approve' => 'অনুদান আবেদন অনুমোদন',
                ]
            ],
        ];
    }
}
