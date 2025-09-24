<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentApplicationService
{
    public function getUserDetails(User $user, $currentAdmin)
    {
        // Moderator permission check
        if ($currentAdmin->role === 'moderator') {
            if (!$this->hasAccess($currentAdmin)) {
                return ['error' => 'permission'];
            }
            $userInfo = UserInformation::where('user_id', $user->id)->first();
            if ($currentAdmin->graduation_year && $userInfo) {
                $graduationYear = $currentAdmin->graduation_year;
                $hasMatchingYear = $userInfo->dept_takmil_year_english == $graduationYear ||
                                   $userInfo->dept_ifta_year_english == $graduationYear ||
                                   $userInfo->dept_hifz_year_english == $graduationYear ||
                                   $userInfo->dept_qirat_year_english == $graduationYear;
                if (!$hasMatchingYear) {
                    return ['error' => 'graduation_year'];
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

        return [
            'user' => $userData,
            'divisions' => $divisions,
            'districts' => $districts,
            'thanas' => $thanas,
        ];
    }

    public function approveUser(User $user, $currentAdmin)
    {
        if (!in_array($currentAdmin->role, ['super_admin', 'admin', 'moderator'])) {
            return ['error' => 'permission'];
        }
        if ($currentAdmin->role === 'moderator' && $currentAdmin->graduation_year) {
            $userInfo = UserInformation::where('user_id', $user->id)->first();
            if ($userInfo) {
                $graduationYear = $currentAdmin->graduation_year;
                $hasMatchingYear = $userInfo->dept_takmil_year_english == $graduationYear ||
                                   $userInfo->dept_ifta_year_english == $graduationYear ||
                                   $userInfo->dept_hifz_year_english == $graduationYear ||
                                   $userInfo->dept_qirat_year_english == $graduationYear;
                if (!$hasMatchingYear) {
                    return ['error' => 'graduation_year'];
                }
            }
        }
        $user->update([
            'status' => User::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => $currentAdmin->id,
        ]);
        return ['success' => true];
    }

    public function rejectUser(User $user, $currentAdmin)
    {
        if ($currentAdmin->role !== 'super_admin') {
            return ['error' => 'permission'];
        }
        $user->update([
            'status' => User::STATUS_REJECTED,
            'approved_at' => null,
            'approved_by' => $currentAdmin->id,
        ]);
        return ['success' => true];
    }

    public function suspendUser(User $user, $currentAdmin)
    {
        if ($currentAdmin->role !== 'super_admin') {
            return ['error' => 'permission'];
        }
        $user->update([
            'status' => User::STATUS_SUSPENDED,
            'approved_at' => null,
            'approved_by' => $currentAdmin->id,
        ]);
        return ['success' => true];
    }

    public function deleteUser(User $user, $currentAdmin)
    {
        if ($currentAdmin->role !== 'super_admin') {
            return ['error' => 'permission'];
        }
        $userName = $user->fullNameBangla;
        $userId = $user->id;
        UserInformation::where('user_id', $user->id)->delete();
        $user->delete();
        return ['success' => true, 'userName' => $userName];
    }
// ...existing code...
    public function hasAccess($admin): bool
    {
        if ($admin->role === 'moderator') {
            return $this->checkPermission($admin, 'document_management_access');
        }
        return true;
    }

    protected function checkPermission($admin, $permission): bool
    {
        return is_array($admin->permissions) && in_array($permission, $admin->permissions);
    }

    public function getIndexData(Request $request, $currentAdmin): array
    {
        $query = $this->buildUserQuery($request, $currentAdmin);

        $perPage = $request->input('per_page', 10);
        $users = $query->orderBy('users.created_at', 'desc')->paginate($perPage);

        // Filter options
        $divisions = DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
        $districts = DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
        $thanas = DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();

        $graduationYears = collect([
            ...UserInformation::whereNotNull('dept_takmil_year_english')->distinct()->pluck('dept_takmil_year_english')->toArray(),
            ...UserInformation::whereNotNull('dept_ifta_year_english')->distinct()->pluck('dept_ifta_year_english')->toArray(),
            ...UserInformation::whereNotNull('dept_hifz_year_english')->distinct()->pluck('dept_hifz_year_english')->toArray(),
            ...UserInformation::whereNotNull('dept_qirat_year_english')->distinct()->pluck('dept_qirat_year_english')->toArray()
        ])->unique()->sort()->values();

        $bloodGroups = UserInformation::whereNotNull('bloodGroup')->distinct()->pluck('bloodGroup')->filter()->values();
        $workplaces = UserInformation::whereNotNull('workplace')->distinct()->pluck('workplace')->filter()->values();

        $departments = collect([
            ['value' => 'takmil', 'label' => 'তাকমিল'],
            ['value' => 'ifta',   'label' => 'ইফতা'],
            ['value' => 'hifz',   'label' => 'হিফজ'],
            ['value' => 'qirat',  'label' => 'কিরাত'],
        ])->filter(function($dept) {
            return UserInformation::whereNotNull("dept_{$dept['value']}")->where("dept_{$dept['value']}", true)->exists();
        })->values();

        $statusOptions = [
            ['value' => User::STATUS_PENDING,   'label' => 'অপেক্ষমান'],
            ['value' => User::STATUS_APPROVED,  'label' => 'অনুমোদিত'],
            ['value' => User::STATUS_REJECTED,  'label' => 'বাতিল'],
            ['value' => User::STATUS_SUSPENDED, 'label' => 'স্থগিত'],
        ];

        return [
            'users'         => $users,
            'divisions'     => $divisions,
            'districts'     => $districts,
            'thanas'        => $thanas,
            'graduationYears' => $graduationYears,
            'bloodGroups'   => $bloodGroups,
            'workplaces'    => $workplaces,
            'departments'   => $departments,
            'statusOptions' => $statusOptions,
            'filters'       => $request->only([
                'search', 'graduation_year', 'division_filter', 'district_filter',
                'thana_filter', 'status_filter', 'blood_group_filter', 'workplace_filter', 'department_filter'
            ])
        ];
    }

    public function getApproveListData(Request $request, $currentAdmin): array
    {
        $query = $this->buildUserQuery($request, $currentAdmin);
        $query->where('users.status', User::STATUS_APPROVED);

        $perPage = $request->input('per_page', 10);
        $users = $query->orderBy('users.created_at', 'desc')->paginate($perPage);

        // Filter options same as getIndexData, but statusOptions only approved
        $divisions = DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
        $districts = DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
        $thanas = DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();

        $graduationYears = collect([
            ...UserInformation::whereNotNull('dept_takmil_year_english')->distinct()->pluck('dept_takmil_year_english')->toArray(),
            ...UserInformation::whereNotNull('dept_ifta_year_english')->distinct()->pluck('dept_ifta_year_english')->toArray(),
            ...UserInformation::whereNotNull('dept_hifz_year_english')->distinct()->pluck('dept_hifz_year_english')->toArray(),
            ...UserInformation::whereNotNull('dept_qirat_year_english')->distinct()->pluck('dept_qirat_year_english')->toArray()
        ])->unique()->sort()->values();

        $bloodGroups = UserInformation::whereNotNull('bloodGroup')->distinct()->pluck('bloodGroup')->filter()->values();
        $workplaces = UserInformation::whereNotNull('workplace')->distinct()->pluck('workplace')->filter()->values();

        $departments = collect([
            ['value' => 'takmil', 'label' => 'তাকমিল'],
            ['value' => 'ifta',   'label' => 'ইফতা'],
            ['value' => 'hifz',   'label' => 'হিফজ'],
            ['value' => 'qirat',  'label' => 'কিরাত'],
        ])->filter(function($dept) {
            return UserInformation::whereNotNull("dept_{$dept['value']}")->where("dept_{$dept['value']}", true)->exists();
        })->values();

        $statusOptions = [
            ['value' => User::STATUS_APPROVED, 'label' => 'অনুমোদিত'],
        ];

        return [
            'users'         => $users,
            'divisions'     => $divisions,
            'districts'     => $districts,
            'thanas'        => $thanas,
            'graduationYears' => $graduationYears,
            'bloodGroups'   => $bloodGroups,
            'workplaces'    => $workplaces,
            'departments'   => $departments,
            'statusOptions' => $statusOptions,
            'filters'       => $request->only([
                'search', 'graduation_year', 'division_filter', 'district_filter',
                'thana_filter', 'blood_group_filter', 'workplace_filter', 'department_filter'
            ])
        ];
    }

    protected function buildUserQuery(Request $request, $currentAdmin)
    {
        $query = User::query()
            ->select([
                'users.id',
                'users.fullNameBangla as full_name_bangla',
                'users.fatherName as father_name',
                'user_informations.photo',
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

        // Filters
        $filters = [
            'search'                => fn($q, $v) => $q->where(function($query) use ($v) {
                $query->where('users.fullNameBangla', 'like', "%{$v}%")
                    ->orWhere('users.id', 'like', "%{$v}%")
                    ->orWhere('users.fatherName', 'like', "%{$v}%")
                    ->orWhere('user_informations.workplace', 'like', "%{$v}%");
            }),
            'division_filter'       => fn($q, $v) => $q->where('user_informations.division_id', $v),
            'district_filter'       => fn($q, $v) => $q->where('user_informations.district_id', $v),
            'thana_filter'          => fn($q, $v) => $q->where('user_informations.thana_id', $v),
            'status_filter'         => fn($q, $v) => $q->where('users.status', $v),
            'blood_group_filter'    => fn($q, $v) => $q->where('user_informations.bloodGroup', $v),
            'workplace_filter'      => fn($q, $v) => $q->where('user_informations.workplace', 'like', "%{$v}%"),
            'department_filter'     => fn($q, $v) => $q->where("user_informations.dept_{$v}", true),
            'graduation_year'       => fn($q, $v) => $q->where(function($query) use ($v) {
                $query->where('user_informations.dept_takmil_year_english', $v)
                    ->orWhere('user_informations.dept_ifta_year_english', $v)
                    ->orWhere('user_informations.dept_hifz_year_english', $v)
                    ->orWhere('user_informations.dept_qirat_year_english', $v);
            }),
        ];

        foreach ($filters as $key => $callback) {
            if ($request->filled($key)) {
                $callback($query, $request->input($key));
            }
        }

        // Moderator-specific graduation year filtering
        if ($currentAdmin->role === 'moderator' && !empty($currentAdmin->graduation_year)) {
            $year = $currentAdmin->graduation_year;
            $query->where(function($q) use ($year) {
                $q->where('user_informations.dept_takmil_year_english', $year)
                    ->orWhere('user_informations.dept_ifta_year_english', $year)
                    ->orWhere('user_informations.dept_hifz_year_english', $year)
                    ->orWhere('user_informations.dept_qirat_year_english', $year);
            });
        }

        return $query;
    }






















    
}