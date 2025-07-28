<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class DocumentApplicationController extends Controller
{
    /**
     * Display document application list
     */
    public function index(Request $request): Response|RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check if moderator has document management access
        if ($currentAdmin->role === 'moderator') {
            if (!$currentAdmin->permissions || !$currentAdmin->permissions['document_management_access']) {
                Log::warning('DocumentApplicationController: Moderator ' . $currentAdmin->id . ' lacks document_management_access. Redirecting to dashboard.');
                return redirect()->route('admin.admin_Dashboard')->withErrors(['error' => 'আপনার দস্তরবন্দি ব্যবস্থাপনার অনুমতি নেই।']);
            }
        }

        $query = User::query()
            ->select([
                'users.id',
                'users.fullNameBangla as full_name_bangla',
                'users.fatherName as father_name',
                'user_informations.dateOfBirth as date_of_birth',
                'user_informations.rollNumber as roll_number',
                'user_informations.workplace',
                'user_informations.bloodGroup',
                'user_informations.division_id',
                'user_informations.district_id',
                'user_informations.thana_id',
                'user_informations.dept_takmil',
                'user_informations.dept_ifta',
                'user_informations.dept_hifz',
                'user_informations.dept_qirat',
                'user_informations.dept_takmil_year_english',
                'user_informations.dept_takmil_year_hijri',
                'user_informations.dept_ifta_year_english',
                'user_informations.dept_ifta_year_hijri',
                'user_informations.dept_hifz_year_english',
                'user_informations.dept_hifz_year_hijri',
                'user_informations.dept_qirat_year_english',
                'user_informations.dept_qirat_year_hijri',
                'users.status',
                'users.created_at',
                'div.Division as division_name',
                'dist.District as district_name',
                'th.Thana as thana_name'
            ])
            ->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
            ->leftJoin('division as div', 'user_informations.division_id', '=', 'div.ID')
            ->leftJoin('district as dist', 'user_informations.district_id', '=', 'dist.DesID')
            ->leftJoin('thana as th', 'user_informations.thana_id', '=', 'th.Thana_ID');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.fullNameBangla', 'like', "%{$search}%")
                  ->orWhere('users.id', 'like', "%{$search}%")
                  ->orWhere('users.fatherName', 'like', "%{$search}%")
                  ->orWhere('user_informations.workplace', 'like', "%{$search}%");
            });
        }

        // Filter by division
        if ($request->filled('division_filter')) {
            $query->where('user_informations.division_id', $request->division_filter);
        }

        // Filter by district
        if ($request->filled('district_filter')) {
            $query->where('user_informations.district_id', $request->district_filter);
        }

        // Filter by thana
        if ($request->filled('thana_filter')) {
            $query->where('user_informations.thana_id', $request->thana_filter);
        }

        // Filter by status
        if ($request->filled('status_filter')) {
            $query->where('users.status', $request->status_filter);
        }

        // Filter by blood group
        if ($request->filled('blood_group_filter')) {
            $query->where('user_informations.bloodGroup', $request->blood_group_filter);
        }

        // Filter by workplace
        if ($request->filled('workplace_filter')) {
            $query->where('user_informations.workplace', 'like', "%{$request->workplace_filter}%");
        }

        // Filter by department
        if ($request->filled('department_filter')) {
            $department = $request->department_filter;
            $query->where("user_informations.dept_{$department}", true);
        }

        // Filter by graduation year
        if ($request->filled('graduation_year')) {
            $graduationYear = $request->graduation_year;
            $query->where(function($q) use ($graduationYear) {
                $q->where('user_informations.dept_takmil_year_english', $graduationYear)
                  ->orWhere('user_informations.dept_ifta_year_english', $graduationYear)
                  ->orWhere('user_informations.dept_hifz_year_english', $graduationYear)
                  ->orWhere('user_informations.dept_qirat_year_english', $graduationYear);
            });
        }

        // Filter by graduation year for moderators (additional restriction for moderators)
        if ($currentAdmin && $currentAdmin->role === 'moderator' && $currentAdmin->graduation_year) {
            $graduationYear = $currentAdmin->graduation_year;
            $query->where(function($q) use ($graduationYear) {
                $q->where('user_informations.dept_takmil_year_english', $graduationYear)
                  ->orWhere('user_informations.dept_ifta_year_english', $graduationYear)
                  ->orWhere('user_informations.dept_hifz_year_english', $graduationYear)
                  ->orWhere('user_informations.dept_qirat_year_english', $graduationYear);
            });
        }

        $perPage = $request->input('per_page', 10);
        $users = $query->orderBy('users.created_at', 'desc')->paginate($perPage);

        // Get filter options
        $divisions = DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
        $districts = DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
        $thanas = DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();

        // Graduation years from user_informations table
        $takmilyears = UserInformation::whereNotNull('dept_takmil_year_english')->distinct()->pluck('dept_takmil_year_english');
        $iftayears = UserInformation::whereNotNull('dept_ifta_year_english')->distinct()->pluck('dept_ifta_year_english');
        $hifzyears = UserInformation::whereNotNull('dept_hifz_year_english')->distinct()->pluck('dept_hifz_year_english');
        $qiratyears = UserInformation::whereNotNull('dept_qirat_year_english')->distinct()->pluck('dept_qirat_year_english');

        $graduationYears = $takmilyears->merge($iftayears)->merge($hifzyears)->merge($qiratyears)->unique()->sort()->values();

        // Get additional filter options from database
        $bloodGroups = UserInformation::whereNotNull('bloodGroup')->distinct()->pluck('bloodGroup')->filter()->values();
        $workplaces = UserInformation::whereNotNull('workplace')->distinct()->pluck('workplace')->filter()->values();

        // Get department filter options (existing departments)
        $departments = [];
        if (UserInformation::whereNotNull('dept_takmil')->where('dept_takmil', true)->exists()) {
            $departments[] = ['value' => 'takmil', 'label' => 'তাকমিল'];
        }
        if (UserInformation::whereNotNull('dept_ifta')->where('dept_ifta', true)->exists()) {
            $departments[] = ['value' => 'ifta', 'label' => 'ইফতা'];
        }
        if (UserInformation::whereNotNull('dept_hifz')->where('dept_hifz', true)->exists()) {
            $departments[] = ['value' => 'hifz', 'label' => 'হিফজ'];
        }
        if (UserInformation::whereNotNull('dept_qirat')->where('dept_qirat', true)->exists()) {
            $departments[] = ['value' => 'qirat', 'label' => 'কিরাত'];
        }

        // Status options
        $statusOptions = [
            ['value' => User::STATUS_PENDING, 'label' => 'অপেক্ষমান'],
            ['value' => User::STATUS_APPROVED, 'label' => 'অনুমোদিত'],
            ['value' => User::STATUS_REJECTED, 'label' => 'বাতিল'],
            ['value' => User::STATUS_SUSPENDED, 'label' => 'স্থগিত'],
        ];

        return Inertia::render('admin/DocumentApplications/Index', [
            'users' => $users,
            'divisions' => $divisions,
            'districts' => $districts,
            'thanas' => $thanas,
            'graduationYears' => $graduationYears,
            'bloodGroups' => $bloodGroups,
            'workplaces' => $workplaces,
            'departments' => $departments,
            'statusOptions' => $statusOptions,
            'filters' => $request->only(['search', 'graduation_year', 'division_filter', 'district_filter', 'thana_filter', 'status_filter', 'blood_group_filter', 'workplace_filter', 'department_filter'])
        ]);
    }

    /**
     * Show user details
     */
    public function show(User $user): Response|RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check if moderator has document management access
        if ($currentAdmin->role === 'moderator') {
            if (!$currentAdmin->permissions || !$currentAdmin->permissions['document_management_access']) {
                Log::warning('DocumentApplicationController: Moderator ' . $currentAdmin->id . ' lacks document_management_access. Redirecting to dashboard.');
                return redirect()->route('admin.admin_Dashboard')->withErrors(['error' => 'আপনার দস্তরবন্দি ব্যবস্থাপনার অনুমতি নেই।']);
            }

            // Check if user belongs to moderator's graduation year
            $userInfo = UserInformation::where('user_id', $user->id)->first();
            if ($currentAdmin->graduation_year && $userInfo) {
                $graduationYear = $currentAdmin->graduation_year;
                $hasMatchingYear = $userInfo->dept_takmil_year_english == $graduationYear ||
                                   $userInfo->dept_ifta_year_english == $graduationYear ||
                                   $userInfo->dept_hifz_year_english == $graduationYear ||
                                   $userInfo->dept_qirat_year_english == $graduationYear;

                if (!$hasMatchingYear) {
                    Log::warning('DocumentApplicationController: Moderator ' . $currentAdmin->id . ' tried to view user ' . $user->id . ' outside their graduation year. Redirecting.');
                    return redirect()->route('admin.documents.applications.index')->withErrors(['error' => 'আপনি শুধুমাত্র আপনার পাস সালের ডাটা দেখতে পারেন।']);
                }
            }
        }

        $userData = User::query()
            ->select([
                'users.*',
                'user_informations.*',
                'user_informations.created_at as info_created_at',
                'user_informations.updated_at as info_updated_at',
                'div.Division as division_name_bangla',
                'dist.District as district_name_bangla',
                'th.Thana as thana_name_bangla',
                'approved_admin.fullNameBangla as approved_by_name'
            ])
            ->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
            ->leftJoin('division as div', 'user_informations.division_id', '=', 'div.ID')
            ->leftJoin('district as dist', 'user_informations.district_id', '=', 'dist.DesID')
            ->leftJoin('thana as th', 'user_informations.thana_id', '=', 'th.Thana_ID')
            ->leftJoin('users as approved_admin', 'users.approved_by', '=', 'approved_admin.id')
            ->where('users.id', $user->id)
            ->firstOrFail();

        $divisions = DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
        $districts = DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
        $thanas = DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();

        return Inertia::render('admin/DocumentApplications/Show', [
            'user' => $userData,
            'divisions' => $divisions,
            'districts' => $districts,
            'thanas' => $thanas,
        ]);
    }

    /**
     * Approve user application
     */
    public function approve(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check if admin can approve (all roles can approve)
        if (!in_array($currentAdmin->role, ['super_admin', 'admin', 'moderator'])) {
            return redirect()->back()->withErrors(['error' => 'আপনার অনুমোদন দেওয়ার অনুমতি নেই।']);
        }

        // For moderators, check graduation year restriction
        if ($currentAdmin->role === 'moderator' && $currentAdmin->graduation_year) {
            $userInfo = UserInformation::where('user_id', $user->id)->first();
            if ($userInfo) {
                $graduationYear = $currentAdmin->graduation_year;
                $hasMatchingYear = $userInfo->dept_takmil_year_english == $graduationYear ||
                                   $userInfo->dept_ifta_year_english == $graduationYear ||
                                   $userInfo->dept_hifz_year_english == $graduationYear ||
                                   $userInfo->dept_qirat_year_english == $graduationYear;

                if (!$hasMatchingYear) {
                    return redirect()->back()->withErrors(['error' => 'আপনি শুধুমাত্র আপনার পাস সালের আবেদন অনুমোদন করতে পারেন।']);
                }
            }
        }

        $user->update([
            'status' => User::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => $currentAdmin->id,
        ]);

        Log::info("User {$user->id} approved by admin {$currentAdmin->id}");

        return redirect()->back()->with('success', 'আবেদনটি সফলভাবে অনুমোদন করা হয়েছে।');
    }

    /**
     * Reject user application - Only Super Admin
     */
    public function reject(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Only super admin can reject
        if ($currentAdmin->role !== 'super_admin') {
            return redirect()->back()->withErrors(['error' => 'শুধুমাত্র সুপার এডমিন আবেদন বাতিল করতে পারেন।']);
        }

        $user->update([
            'status' => User::STATUS_REJECTED,
            'approved_at' => null,
            'approved_by' => $currentAdmin->id,
        ]);

        Log::info("User {$user->id} rejected by super admin {$currentAdmin->id}");

        return redirect()->back()->with('success', 'আবেদনটি সফলভাবে বাতিল করা হয়েছে।');
    }

    /**
     * Suspend user application - Only Super Admin
     */
    public function suspend(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Only super admin can suspend
        if ($currentAdmin->role !== 'super_admin') {
            return redirect()->back()->withErrors(['error' => 'শুধুমাত্র সুপার এডমিন আবেদন স্থগিত করতে পারেন।']);
        }

        $user->update([
            'status' => User::STATUS_SUSPENDED,
            'approved_at' => null,
            'approved_by' => $currentAdmin->id,
        ]);

        Log::info("User {$user->id} suspended by super admin {$currentAdmin->id}");

        return redirect()->back()->with('success', 'আবেদনটি সফলভাবে স্থগিত করা হয়েছে।');
    }

    /**
     * Delete user application - Only Super Admin
     */
    public function destroy(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Only super admin can delete
        if ($currentAdmin->role !== 'super_admin') {
            return redirect()->back()->withErrors(['error' => 'শুধুমাত্র সুপার এডমিন আবেদন মুছতে পারেন।']);
        }

        $userName = $user->fullNameBangla;
        $userId = $user->id;

        // Delete associated user information first (if exists)
        UserInformation::where('user_id', $user->id)->delete();

        // Delete the user
        $user->delete();

        Log::info("User {$userId} ({$userName}) deleted by super admin {$currentAdmin->id}");

        return redirect()->route('admin.documents.applications.index')->with('success', "আবেদনটি ({$userName}) সফলভাবে মুছে ফেলা হয়েছে।");
    }
}
