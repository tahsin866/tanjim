<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class StudentRegistrationController extends Controller
{
    public function studentData(Request $request)
{
    $students = User::with(['information'])
        ->where('id', Auth::user()->id) // লগইন ইউজারের তথ্য
        ->get();

    $divisions = DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
    $districts = DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
    $thanas = DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();

    $students = $students->map(function ($user) {
        $info = $user->information;
        return [
            'id' => $user->id,
            'fullNameBangla' => $user->fullNameBangla,
            'fullNameEnglish' => $user->fullNameEnglish,
            'fatherName' => $user->fatherName,
            'phoneNumber' => $user->phoneNumber,
            'alternatePhoneNumber' => optional($info)->alternatePhoneNumber,
            'dateOfBirth' => optional($info)->dateOfBirth,
            'bloodGroup' => optional($info)->bloodGroup,
            'address' => optional($info)->address,
            'division' => optional($info)->division_id,
            'district' => optional($info)->district_id,
            'thana' => optional($info)->thana_id,
            'classmate1' => optional($info)->classmate1,
            'classmate2' => optional($info)->classmate2,
            'classmate3' => optional($info)->classmate3,
            'dept_takmil' => is_null(optional($info)->dept_takmil) ? false : (bool)optional($info)->dept_takmil,
            'dept_ifta' => is_null(optional($info)->dept_ifta) ? false : (bool)optional($info)->dept_ifta,
            'dept_hifz' => is_null(optional($info)->dept_hifz) ? false : (bool)optional($info)->dept_hifz,
            'dept_qirat' => is_null(optional($info)->dept_qirat) ? false : (bool)optional($info)->dept_qirat,
            'dept_other' => is_null(optional($info)->dept_other) ? false : (bool)optional($info)->dept_other,
            'dept_takmil_year_english' => optional($info)->dept_takmil_year_english,
            'dept_takmil_year_hijri' => optional($info)->dept_takmil_year_hijri,
            'dept_ifta_year_english' => optional($info)->dept_ifta_year_english,
            'dept_ifta_year_hijri' => optional($info)->dept_ifta_year_hijri,
            'dept_hifz_year_english' => optional($info)->dept_hifz_year_english,
            'dept_hifz_year_hijri' => optional($info)->dept_hifz_year_hijri,
            'dept_qirat_year_english' => optional($info)->dept_qirat_year_english,
            'dept_qirat_year_hijri' => optional($info)->dept_qirat_year_hijri,

            'dept_other_class' => optional($info)->dept_other_class,
            'examType' => optional($info)->examType,
            'rollNumber' => optional($info)->rollNumber,
            'workplace' => optional($info)->workplace,
            'idType' => optional($info)->idType,
            'birthCertificate' => optional($info)->birthCertificate,
            'voterId' => optional($info)->voterId,
            'birthCertificatePhoto' => optional($info)->birthCertificatePhoto,
            'voterIdPhoto' => optional($info)->voterIdPhoto,
            'photo' => optional($info)->photo,
            'status' => $user->status ?? 'pending',
            'created_at' => $user->created_at,
            'approved_at' => $user->approved_at,
        ];
    });

    return Inertia::render('madrashaDashboard/studentData', [
        'students' => $students,
        'divisions' => $divisions,
        'districts' => $districts,
        'thanas' => $thanas,
    ]);
}



    public function editStudentPage(User $student)
    {
        $student->load('information'); // Eager load the information relationship

        $divisions = DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
        $districts = DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
        $thanas = DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();

        return Inertia::render('madrashaDashboard/StudentEdit', [
            'student' => $student,
            'divisions' => $divisions,
            'districts' => $districts,
            'thanas' => $thanas,
        ]);
    }

public function updateStudent(Request $request, $id)
{
    $user = User::findOrFail($id);
    $userInfo = $user->information;

    // Make sure boolean fields are always boolean, not string/null
    $request->merge([
        'dept_takmil' => filter_var($request->input('dept_takmil', false), FILTER_VALIDATE_BOOLEAN),
        'dept_ifta' => filter_var($request->input('dept_ifta', false), FILTER_VALIDATE_BOOLEAN),
        'dept_hifz' => filter_var($request->input('dept_hifz', false), FILTER_VALIDATE_BOOLEAN),
        'dept_qirat' => filter_var($request->input('dept_qirat', false), FILTER_VALIDATE_BOOLEAN),
        'dept_other' => filter_var($request->input('dept_other', false), FILTER_VALIDATE_BOOLEAN),
    ]);

    // Update User model, fallback to old value if not present
    $user->update([
        'fullNameBangla'   => $request->input('fullNameBangla', $user->fullNameBangla),
        'fullNameEnglish'  => $request->input('fullNameEnglish', $user->fullNameEnglish),
        'fatherName'       => $request->input('fatherName', $user->fatherName),
        'phoneNumber'      => $request->input('phoneNumber', $user->phoneNumber),
    ]);

    // Prepare data for UserInformation model
    $informationData = [
        'alternatePhoneNumber'    => $request->input('alternatePhoneNumber', $userInfo ? $userInfo->alternatePhoneNumber : null),
        'dateOfBirth'             => $request->input('dateOfBirth', $userInfo ? $userInfo->dateOfBirth : null),
        'bloodGroup'              => $request->input('bloodGroup', $userInfo ? $userInfo->bloodGroup : null),
        'address'                 => $request->input('address', $userInfo ? $userInfo->address : null),
        'division_id'             => $request->input('division', $userInfo ? $userInfo->division_id : null),
        'district_id'             => $request->input('district', $userInfo ? $userInfo->district_id : null),
        'thana_id'                => $request->input('thana', $userInfo ? $userInfo->thana_id : null),
        'classmate1'              => $request->input('classmate1', $userInfo ? $userInfo->classmate1 : null),
        'classmate2'              => $request->input('classmate2', $userInfo ? $userInfo->classmate2 : null),
        'classmate3'              => $request->input('classmate3', $userInfo ? $userInfo->classmate3 : null),
        'dept_takmil'             => $request->input('dept_takmil', $userInfo ? $userInfo->dept_takmil : false),
        'dept_ifta'               => $request->input('dept_ifta', $userInfo ? $userInfo->dept_ifta : false),
        'dept_hifz'               => $request->input('dept_hifz', $userInfo ? $userInfo->dept_hifz : false),
        'dept_qirat'              => $request->input('dept_qirat', $userInfo ? $userInfo->dept_qirat : false),
        'dept_other'              => $request->input('dept_other', $userInfo ? $userInfo->dept_other : false),
        'dept_takmil_year_english'=> $request->input('dept_takmil_year_english', $userInfo ? $userInfo->dept_takmil_year_english : null),
        'dept_takmil_year_hijri'  => $request->input('dept_takmil_year_hijri', $userInfo ? $userInfo->dept_takmil_year_hijri : null),
        'dept_ifta_year_english'  => $request->input('dept_ifta_year_english', $userInfo ? $userInfo->dept_ifta_year_english : null),
        'dept_ifta_year_hijri'    => $request->input('dept_ifta_year_hijri', $userInfo ? $userInfo->dept_ifta_year_hijri : null),
        'dept_hifz_year_english'  => $request->input('dept_hifz_year_english', $userInfo ? $userInfo->dept_hifz_year_english : null),
        'dept_hifz_year_hijri'    => $request->input('dept_hifz_year_hijri', $userInfo ? $userInfo->dept_hifz_year_hijri : null),
        'dept_qirat_year_english' => $request->input('dept_qirat_year_english', $userInfo ? $userInfo->dept_qirat_year_english : null),
        'dept_qirat_year_hijri'   => $request->input('dept_qirat_year_hijri', $userInfo ? $userInfo->dept_qirat_year_hijri : null),

        'dept_other_class'        => $request->input('dept_other_class', $userInfo ? $userInfo->dept_other_class : null),
        'examType'                => $request->input('examType', $userInfo ? $userInfo->examType : null),
        'rollNumber'              => $request->input('rollNumber', $userInfo ? $userInfo->rollNumber : null),
        'workplace'               => $request->input('workplace', $userInfo ? $userInfo->workplace : null),
        'idType'                  => $request->input('idType', $userInfo ? $userInfo->idType : null),
        'birthCertificate'        => $request->input('birthCertificate', $userInfo ? $userInfo->birthCertificate : null),
        'voterId'                 => $request->input('voterId', $userInfo ? $userInfo->voterId : null),
    ];

    // File upload same as before
    if ($request->hasFile('birthCertificatePhoto')) {
        if ($userInfo && $userInfo->birthCertificatePhoto && Storage::disk('public')->exists($userInfo->birthCertificatePhoto)) {
            Storage::disk('public')->delete($userInfo->birthCertificatePhoto);
        }
        $informationData['birthCertificatePhoto'] = $request->file('birthCertificatePhoto')->store('user-documents', 'public');
    }
    if ($request->hasFile('voterIdPhoto')) {
        if ($userInfo && $userInfo->voterIdPhoto && Storage::disk('public')->exists($userInfo->voterIdPhoto)) {
            Storage::disk('public')->delete($userInfo->voterIdPhoto);
        }
        $informationData['voterIdPhoto'] = $request->file('voterIdPhoto')->store('user-documents', 'public');
    }
    if ($request->hasFile('photo')) {
        if ($userInfo && $userInfo->photo && Storage::disk('public')->exists($userInfo->photo)) {
            Storage::disk('public')->delete($userInfo->photo);
        }
        $informationData['photo'] = $request->file('photo')->store('user-photos', 'public');
    }

    // Update or create UserInformation model
    if ($userInfo) {
        $userInfo->update($informationData);
    } else {
        $user->information()->create($informationData);
    }

    return redirect()->back()->with('success', 'শিক্ষার্থীর তথ্য সফলভাবে আপডেট করা হয়েছে!');
}



public function studentDetails($id)
{
    $student = \App\Models\User::select([
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

    $divisions = DB::table('division')->select('ID as id', 'Division as division_name_bangla')->get();
    $districts = DB::table('district')->select('DesID as id', 'District as district_name_bangla', 'DID as division_id')->get();
    $thanas = DB::table('thana')->select('Thana_ID as id', 'Thana as thana_name_bangla', 'Des_ID as district_id')->get();

    return inertia('madrashaDashboard/StudentDetails', [
        'student' => $student,
        'divisions' => $divisions,
        'districts' => $districts,
        'thanas' => $thanas,
    ]);
}


/**
 * Return student stats for dashboard API
 */
public function studentStats(Request $request)
{
    // Example: return total students and approved students
    $total = \App\Models\User::count();
    $approved = \App\Models\User::where('status', 'approved')->count();
    return response()->json([
        'total' => $total,
        'approved' => $approved,
    ]);
}
}
