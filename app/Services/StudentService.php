<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    /**
     * Get all students for a user (example: all students registered by this user)
     */
    public function getStudentData($userId)
    {
        // You can adjust the query as needed for your logic
        return User::with('information')->where('created_by', $userId)->get();
    }
    /**
     * Get single student basic info
     */
    public function getSingleStudent($id)
    {
        return User::with('information')->findOrFail($id);
    }
    /**
     * Update student and related information
     */
    public function updateStudent(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $userInfo = $user->information;

        // Ensure booleans are stored correctly
        $request->merge([
            'dept_takmil' => filter_var($request->input('dept_takmil', false), FILTER_VALIDATE_BOOLEAN),
            'dept_ifta'   => filter_var($request->input('dept_ifta', false), FILTER_VALIDATE_BOOLEAN),
            'dept_hifz'   => filter_var($request->input('dept_hifz', false), FILTER_VALIDATE_BOOLEAN),
            'dept_qirat'  => filter_var($request->input('dept_qirat', false), FILTER_VALIDATE_BOOLEAN),
            'dept_adab'   => filter_var($request->input('dept_adab', false), FILTER_VALIDATE_BOOLEAN),
            'dept_other'  => filter_var($request->input('dept_other', false), FILTER_VALIDATE_BOOLEAN),
        ]);

        // Update User basic info
        $user->update([
            'fullNameBangla'  => $request->input('fullNameBangla', $user->fullNameBangla),
            'fullNameEnglish' => $request->input('fullNameEnglish', $user->fullNameEnglish),
            'fatherName'      => $request->input('fatherName', $user->fatherName),
            'phoneNumber'     => $request->input('phoneNumber', $user->phoneNumber),
        ]);

        // Prepare information data
        $informationData = $this->prepareInformationData($request, $userInfo);

        // Handle file uploads
        $informationData = $this->handleFileUploads($request, $userInfo, $informationData);

        // Update or create related info
        if ($userInfo) {
            $userInfo->update($informationData);
        } else {
            $user->information()->create($informationData);
        }

        return $user;
    }

    /**
     * Prepare user information update payload
     */
    private function prepareInformationData(Request $request, $userInfo)
    {
        return [
            'alternatePhoneNumber'    => $request->input('alternatePhoneNumber', $userInfo->alternatePhoneNumber ?? null),
            'dateOfBirth'             => $request->input('dateOfBirth', $userInfo->dateOfBirth ?? null),
            'bloodGroup'              => $request->input('bloodGroup', $userInfo->bloodGroup ?? null),
            'address'                 => $request->input('address', $userInfo->address ?? null),
            'division_id'             => $request->input('division', $userInfo->division_id ?? null),
            'district_id'             => $request->input('district', $userInfo->district_id ?? null),
            'thana_id'                => $request->input('thana', $userInfo->thana_id ?? null),
            'classmate1'              => $request->input('classmate1', $userInfo->classmate1 ?? null),
            'classmate2'              => $request->input('classmate2', $userInfo->classmate2 ?? null),
            'classmate3'              => $request->input('classmate3', $userInfo->classmate3 ?? null),
            'dept_takmil'             => $request->input('dept_takmil', $userInfo->dept_takmil ?? false),
            'dept_ifta'               => $request->input('dept_ifta', $userInfo->dept_ifta ?? false),
            'dept_hifz'               => $request->input('dept_hifz', $userInfo->dept_hifz ?? false),
            'dept_qirat'              => $request->input('dept_qirat', $userInfo->dept_qirat ?? false),
            'dept_adab'               => $request->input('dept_adab', $userInfo->dept_adab ?? false),
            'dept_other'              => $request->input('dept_other', $userInfo->dept_other ?? false),
            'dept_takmil_year_english'=> $request->input('dept_takmil_year_english', $userInfo->dept_takmil_year_english ?? null),
            'dept_takmil_year_hijri'  => $request->input('dept_takmil_year_hijri', $userInfo->dept_takmil_year_hijri ?? null),
            'dept_ifta_year_english'  => $request->input('dept_ifta_year_english', $userInfo->dept_ifta_year_english ?? null),
            'dept_ifta_year_hijri'    => $request->input('dept_ifta_year_hijri', $userInfo->dept_ifta_year_hijri ?? null),
            'dept_hifz_year_english'  => $request->input('dept_hifz_year_english', $userInfo->dept_hifz_year_english ?? null),
            'dept_hifz_year_hijri'    => $request->input('dept_hifz_year_hijri', $userInfo->dept_hifz_year_hijri ?? null),
            'dept_qirat_year_english' => $request->input('dept_qirat_year_english', $userInfo->dept_qirat_year_english ?? null),
            'dept_qirat_year_hijri'   => $request->input('dept_qirat_year_hijri', $userInfo->dept_qirat_year_hijri ?? null),
            'dept_adab_year_english'  => $request->input('dept_adab_year_english', $userInfo->dept_adab_year_english ?? null),
            'dept_adab_year_hijri'    => $request->input('dept_adab_year_hijri', $userInfo->dept_adab_year_hijri ?? null),
            'dept_other_class'        => $request->input('dept_other_class', $userInfo->dept_other_class ?? null),
            'examType'                => $request->input('examType', $userInfo->examType ?? null),
            'rollNumber'              => $request->input('rollNumber', $userInfo->rollNumber ?? null),
            'workplace'               => $request->input('workplace', $userInfo->workplace ?? null),
            'idType'                  => $request->input('idType', $userInfo->idType ?? null),
            'birthCertificate'        => $request->input('birthCertificate', $userInfo->birthCertificate ?? null),
            'voterId'                 => $request->input('voterId', $userInfo->voterId ?? null),
            'passport_id'             => $request->input('passport_id', $userInfo->passport_id ?? null),
        ];
    }

    /**
     * Handle user file uploads
     */
    private function handleFileUploads(Request $request, $userInfo, array $informationData)
    {
        $fileFields = [
            'birthCertificatePhoto' => 'user-documents',
            'voterIdPhoto'          => 'user-documents',
            'passport_photo'        => 'user-documents',
            'photo'                 => 'user-photos',
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                if ($userInfo && $userInfo->{$field} && Storage::disk('public')->exists($userInfo->{$field})) {
                    Storage::disk('public')->delete($userInfo->{$field});
                }
                $informationData[$field] = $request->file($field)->store($folder, 'public');
            }
        }

        return $informationData;
    }

    /**
     * Get single student details with joins
     */
    public function getStudentDetails($id)
    {
        return User::select([
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
            ->findOrFail($id);
    }

    /**
     * Get student statistics
     */
    public function getStudentStats()
    {
        return [
            'totalStudents' => User::count(),
            'approvedStudents' => User::where('status', 'approved')->count(),
            'boardSubmittedStudents' => User::where('status', 'submitted')->count(),
            'boardReturnedStudents' => User::where('status', 'returned')->count(),
        ];
    }

    /**
     * Get divisions
     */
    public function getDivisions()
    {
        return DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
    }

    /**
     * Get districts
     */
    public function getDistricts()
    {
        return DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
    }

    /**
     * Get thanas
     */
    public function getThanas()
    {
        return DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();
    }
}
