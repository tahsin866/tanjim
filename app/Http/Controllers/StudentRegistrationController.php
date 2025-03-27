<?php

namespace App\Http\Controllers;
use App\Models\reg_stu_information;
use App\Models\reg_stu_information_log;
use App\Models\MarkazAgreementMadrasa;
use Illuminate\Support\Facades\Storage;

use App\Models\student;
use Illuminate\Http\Request;
use MirazMac\BanglaString\Translator\BijoyToAvro\Translator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\marhala_for_admin\ExamFee;
use App\Models\MarkazAgreement;
use Illuminate\Support\Facades\DB;

class StudentRegistrationController extends Controller
{


    public function editOldStudent($marhalaId, $roll, $reg_id)
    {
        // Find the student from students table
        $student = Student::where('Roll', $roll)
            ->where('reg_id', $reg_id)
            ->first();

        if (!$student) {
            return redirect()->back()->with('error', 'ছাত্র খুঁজে পাওয়া যায়নি');
        }

        // Check if student already has data in reg_stu_informations table
        $studentInfo = reg_stu_information::where('roll', $roll)
            ->where('reg_id', $reg_id)
            ->first();

        // Create translator instance for displaying Bengali data
        $translator = new Translator();

        // Translate the student data
        $student->Name = $translator->translate($student->Name);
        $student->Father = $translator->translate($student->Father);
        $student->Mother = $translator->translate($student->Mother ?? '');
        $student->DateofBirth = $translator->translate($student->DateofBirth);

        return Inertia::render('StudentRegistration/old_stu_reg_Form', [
            'student' => $student,
            'studentInfo' => $studentInfo,
            'marhalaId' => $marhalaId ?? null
        ]);
    }






    public function updateStudentInfo(Request $request)
    {
        $validated = $request->validate([
            'roll' => 'required',
            'reg_id' => 'required',
            'name_bn' => 'required',
            'name_en' => 'nullable',
            'name_ar' => 'nullable',
            'father_name_bn' => 'required',
            'father_name_en' => 'nullable',
            'father_name_ar' => 'nullable',
            'mother_name_bn' => 'nullable',
            'mother_name_en' => 'nullable',
            'mother_name_ar' => 'nullable',
            'BRN_no' => 'nullable',
            'NID_no' => 'nullable',
        ]);

        // Update or create record in reg_stu_informations table
        reg_stu_information::updateOrCreate(
            ['roll' => $validated['roll'], 'reg_id' => $validated['reg_id']],
            $validated
        );

        // Update mother's name in students table if provided
        if (!empty($validated['mother_name_bn'])) {
            Student::where('Roll', $validated['roll'])
                ->where('reg_id', $validated['reg_id'])
                ->update(['Mother' => $validated['mother_name_bn']]);
        }

        return redirect()->back()->with('success', 'ছাত্রের তথ্য সফলভাবে আপডেট করা হয়েছে');
    }




















    public function getStudents()
    {
        $students = reg_stu_information::where('user_id', Auth::id())->select(
            'id',
            'student_image',
            'name_bn',
            'father_name_bn',
            'current_madrasha',
            'Date_of_birth',
            'student_type',
            'exam_name_Bn'
        )->get();

        // প্রতিটি ছাত্রের জন্য status যোগ করা
        foreach ($students as $student) {
            $log = reg_stu_information_log::where('reg_student_id', $student->id)
                ->latest()
                ->first();
            $student->status = $log ? $log->status : null;
        }

        return response()->json($students);
    }





    public function reg_submitApplication($id)
    {
        // 1️⃣ First check markaz_agreements table
        $registration = reg_stu_information::find($id);
        if (!$registration) {
            return back()->withErrors(['error' => 'আবেদন পাওয়া যায়নি!']);
        }

        // 2️⃣ Now check schedule timing before anything else
        $schedule = ExamFee::where('exam_setup_id', $registration->exam_id)
            // ->where('schedule_type', 'মারকায আবেদন')
            // ->where('is_active', true)
            ->first();

        if (!$schedule) {
            return back()->withErrors(['error' => 'সময়সূচী পাওয়া যায়নি!']);
        }

        $currentDate = now();
        $startDate = \Carbon\Carbon::parse($schedule->reg_date_from);
        $endDate = \Carbon\Carbon::parse($schedule->reg_date_to);

        if ($currentDate->lt($startDate)) {
            return back()->withErrors(['error' => 'আবেদনের সময় শুরু হয়নি! ' . $startDate->format('d-m-Y') . ' তারিখে আবার চেষ্টা করুন।']);
        }

        if ($currentDate->gt($endDate)) {
            return back()->withErrors(['error' => 'আবেদনের সময় শেষ! আগামী বছর আবার চেষ্টা করুন।']);
        }



        // 4️⃣ If all checks pass, then create activity log
        reg_stu_information_log::create([
            'reg_student_id' => $registration->id,
            'user_id' => Auth::user()->id,
            'status' => 'বোর্ড দাখিল',
            'actor_type' => 'user',
            'user_name' => Auth::user()->name,
            'user_position' => Auth::user()->admin_Designation,
            'admin_position' => null,
            'admin_message' => null,
            'admin_feedback_image' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'আবেদন সফলভাবে সাবমিট হয়েছে!');
    }







    // এডমিন পার্ট









    // public function getMarkazStudents()
// {
//     // markaz_agreements টেবিল থেকে শুরু করে, প্রতিটি markaz_id একবারই দেখানো হবে
//     $students = DB::table('markaz_agreements')
//         ->select(
//             'markaz_agreements.id',
//             'markaz_agreements.madrasha_Name',
//             'markaz_agreements.Elhaq_no',
//             'markaz_agreements.madrasha_code',
//             DB::raw('(SELECT exam_name_Bn FROM reg_stu_informations WHERE markaz_id = markaz_agreements.id LIMIT 1) as exam_name_Bn'),
//             DB::raw('COUNT(reg_stu_informations.id) as student_count')
//         )
//         ->leftJoin('reg_stu_informations', 'markaz_agreements.id', '=', 'reg_stu_informations.markaz_id')
//         ->groupBy(
//             'markaz_agreements.id',
//             'markaz_agreements.madrasha_Name',
//             'markaz_agreements.Elhaq_no',
//             'markaz_agreements.madrasha_code'
//         )
//         ->having('student_count', '>', 0)
//         ->get();

    //     return response()->json($students);
// }


    public function getMarkazStudents()
    {
        $students = DB::table('reg_stu_informations')
            ->select(
                'reg_stu_informations.markaz_id as id',
                DB::raw('(SELECT MName FROM madrasha WHERE id = reg_stu_informations.markaz_id LIMIT 1) as madrasha_Name'),
                DB::raw('(SELECT ElhaqNo FROM madrasha WHERE id = reg_stu_informations.markaz_id LIMIT 1) as Elhaq_no'),
                'reg_stu_informations.exam_name_Bn',
                DB::raw('COUNT(reg_stu_informations.id) as student_count')
            )
            ->whereNotNull('reg_stu_informations.markaz_id')
            ->groupBy(
                'reg_stu_informations.markaz_id',
                'reg_stu_informations.exam_name_Bn'
            )
            ->having('student_count', '>', 0)
            ->get();

        // After getting the results, fetch the custom_code for each record
        foreach ($students as $student) {
            $user = DB::table('users')
                ->where('madrasha_id', function ($query) use ($student) {
                    $query->select('madrasha_id')
                        ->from('reg_stu_informations')
                        ->where('markaz_id', $student->id)
                        ->limit(1);
                })
                ->select('custom_code')
                ->first();

            $student->madrasha_code = $user ? $user->custom_code : null;
        }

        return response()->json($students);
    }






















    // public function abandonStuList($markaz_id)
// {
//     // মারকাজ আইডি অনুযায়ী শুধু মাদরাসার নাম ও আইডি সিলেক্ট করা
//     $madrashaList = MarkazAgreementMadrasa::where('markaz_agreement_id', $markaz_id)
//         ->select('id', 'madrasa_Name')
//         ->get();

    //     // মারকাজের নাম পাওয়া
//     $markazName = MarkazAgreement::where('id', $markaz_id)
//         ->value('madrasha_Name');

    //     return Inertia::render('nibondon_for_admin/abandon_stu_list', [
//         'madrashaList' => $madrashaList,
//         'markazName' => $markazName
//     ]);
// }






    public function getMarkazMadrasaList($markaz_id)
    {
        // Get all MRID values from stu_rledger_p table where MDID matches the markaz ID
        $mridValues = DB::table('stu_rledger_p')
            ->where('MDID', $markaz_id)
            ->pluck('MRID')
            ->unique()
            ->toArray();

        // Get madrashas where id matches any of the MRID values
        $madrashaList = DB::table('madrasha')
            ->whereIn('id', $mridValues)
            ->select('id', 'MName as name', 'ElhaqNo as Elhaq_no', 'Mobile as mobile_no')
            ->get();

        // Get the markaz name
        $markazName = DB::table('madrasha')
            ->where('id', $markaz_id)
            ->value('MName');

        return response()->json([
            'madrashaList' => $madrashaList,
            'markazName' => $markazName
        ]);
    }


    public function abandonStuList($markaz_id)
    {
        // Just render the view, data will be fetched on the client side
        return Inertia::render('nibondon_for_admin/abandon_stu_list', [
            'markaz_id' => $markaz_id
        ]);
    }





    public function madrashaWariStuNibondList($madrasha_id = null)
    {
        // মাদরাসা আইডি অনুসারে ছাত্রদের তালিকা পাওয়া
        $students = [];

        if ($madrasha_id) {
            // reg_stu_informations টেবিল থেকে ছাত্রদের তথ্য সংগ্রহ করা
            $students = DB::table('reg_stu_informations')
                ->where('madrasha_id', $madrasha_id)
                ->select('id', 'name_bn', 'Date_of_birth', 'father_name_bn', 'mother_name_bn', 'student_image')
                ->get();
        }

        return Inertia::render('nibondon_for_admin/madrashaWari_stu_nibond_list', [
            'students' => $students,
            'madrasha_id' => $madrasha_id
        ]);
    }




    // public function getMadrashaStudents($madrasha_id)
// {
//     $students = reg_stu_information::where('madrasha_id', $madrasha_id)
//         ->select('id', 'name_bn as name')
//         ->get();

    //     return Inertia::render('nibondon_for_admin/madrashaWari_stu_nibond_list', [
//         'students' => $students,
//         'madrasha_id' => $madrasha_id
//     ]);
// }







    public function editStudentRegistration($id)
    {
        // Find the student record
        $student = reg_stu_information::findOrFail($id);

        // Get marhalas for dropdown
        $marhalas = DB::table('marhalas')->get();

        // Return Inertia response to render Vue component
        return Inertia::render('students_registration/student_registration_edit', [
            'student' => $student,
            'marhalas' => $marhalas
        ]);
    }

    public function updateStudentRegistration(Request $request, $id)
    {
        $request->validate([
            'name_bn' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'father_name_bn' => 'required|string|max:255',
            'father_name_en' => 'nullable|string|max:255',
            'father_name_ar' => 'nullable|string|max:255',
            'mother_name_bn' => 'nullable|string|max:255',
            'mother_name_en' => 'nullable|string|max:255',
            'mother_name_ar' => 'nullable|string|max:255',
            'BRN_no' => 'nullable|string|max:255',
            'NID_no' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|max:255',

        ]);

        // Find the student record
        $student = reg_stu_information::findOrFail($id);

        // Handle file uploads
        if ($request->hasFile('student_image')) {
            // Delete old image if exists
            if ($student->student_image) {
                Storage::disk('public')->delete($student->student_image);
            }
            $studentImagePath = $request->file('student_image')->store('student_images', 'public');
            $student->student_image = $studentImagePath;
        }

        if ($request->hasFile('NID_attach')) {
            // Delete old attachment if exists
            if ($student->NID_attach) {
                Storage::disk('public')->delete($student->NID_attach);
            }
            $nidAttachmentPath = $request->file('NID_attach')->store('nid_attachments', 'public');
            $student->NID_attach = $nidAttachmentPath;
        }

        // Get marhala information
        $marhala = null;
        if ($request->marhala_id) {
            $marhala = DB::table('marhalas')
                ->select('id', 'marhala_name_bn')
                ->where('id', $request->marhala_id)
                ->first();
        }

        // Update student information
        $student->name_bn = $request->name_bn;
        $student->name_en = $request->name_en;
        $student->name_ar = $request->name_ar;
        $student->father_name_bn = $request->father_name_bn;
        $student->father_name_en = $request->father_name_en;
        $student->father_name_ar = $request->father_name_ar;
        $student->mother_name_bn = $request->mother_name_bn;
        $student->mother_name_en = $request->mother_name_en;
        $student->mother_name_ar = $request->mother_name_ar;
        $student->board_name = $request->board_name;

        $student->present_division_name = $request->present_division_name;
        $student->present_district_name = $request->present_district_name;
        $student->present_thana_name = $request->present_thana_name;
        $student->presernt_DID = $request->presernt_DID;
        $student->present_desId = $request->present_desId;
        $student->present_TID = $request->present_TID;

        $student->parmanent_division_name = $request->parmanent_division_name;
        $student->parmanent_district_name = $request->parmanent_district_name;
        $student->parmanent_thana_name = $request->parmanent_thana_name;
        $student->parmanent_DID = $request->parmanent_DID;
        $student->parmanent_desId = $request->parmanent_desId;
        $student->parmanent_TID = $request->parmanent_TID;

        $student->BRN_no = $request->BRN_no;
        $student->NID_no = $request->NID_no;
        $student->mobile_no = $request->mobile_no;
        $student->Date_of_birth = $request->Date_of_birth;
        $student->student_type = $request->student_type ?? 'নিয়মিত';

        // Update marhala/class information if provided
        if ($marhala) {
            $student->current_class = $marhala->marhala_name_bn;
            $student->marhala_id = $marhala->id;
        }

        // Update address information


        $student->save();

        return redirect()->back()
            ->with('success', 'Student information updated successfully');

    }






    public function studentRegistrationView($id)
    {
        // reg_stu_informations টেবিল থেকে ডাটা নিয়ে আসা
        $student = reg_stu_information::findOrFail($id);

        // পুরো ডাটা পাঠানো হচ্ছে
        return inertia('students_registration/student_registraion_view', [
            'student' => $student
        ]);
    }




    public function studentRegistrationDelete($id)
    {
        $student = reg_stu_information::find($id);

        if (!$student) {
            return response()->json(['error' => 'আবেদন পাওয়া যায়নি!'], 404);
        }

        $student->delete();

        return redirect()->back()->with('success', 'আবেদন সফলভাবে মুছে ফেলা হয়েছে!');
    }



}
