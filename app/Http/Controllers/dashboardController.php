<?php

namespace App\Http\Controllers;
use App\Models\reg_stu_information;
use App\Models\admin_permission;
use App\Models\student_reg_payment;
use App\Models\reg_stu_information_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use inertia\inertia;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{


    public function getStudentStats()
    {
        // Auth::check() দিয়ে চেক করুন যে ইউজার লগইন আছে কিনা
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            // যদি ইউজার লগইন না থাকে তাহলে একটি এরর রিটার্ন করুন
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // মোট নিবন্ধিত শিক্ষার্থী সংখ্যা
        $totalStudents = reg_stu_information::where('user_id', $userId)->count();

        // ডিবাগিং করুন - সমস্যা খুঁজে বের করতে
        $studentsWithLogs = reg_stu_information::where('user_id', $userId)->with('latestLog')->get();

        $boardSubmittedCount = 0;
        $approvedCount = 0;
        $boardReturnedCount = 0;

        foreach ($studentsWithLogs as $student) {
            if ($student->latestLog && $student->latestLog->status === 'বোর্ড দাখিল') {
                $boardSubmittedCount++;
            } elseif ($student->latestLog && $student->latestLog->status === 'অনুমোদন') {
                $approvedCount++;
            } elseif ($student->latestLog && $student->latestLog->status === 'বোর্ড ফেরত') {
                $boardReturnedCount++;
            }
        }

        return response()->json([
            'totalStudents' => $totalStudents,
            'boardSubmittedStudents' => $boardSubmittedCount,
            'approvedStudents' => $approvedCount,
            'boardReturnedStudents' => $boardReturnedCount,
        ]);
    }






    public function getPaymentStats(Request $request)
    {
        // ইউজার আইডি থেকে ডাটা নিয়ে আসা
        $userId = $request->user()->id;

        // reg_stu_informations টেবিল থেকে এই ইউজারের ছাত্রদের তথ্য নিয়ে আসা
        // exam_fees টেবিলের সাথে জয়েন করা - exam_id কে exam_setup_id এর সাথে জয়েন করা
        $students = reg_stu_information::join('exam_fees as ef', 'reg_stu_informations.exam_id', '=', 'ef.exam_setup_id')
            ->where('reg_stu_informations.user_id', $userId)
            ->select(
                'reg_stu_informations.id',
                'reg_stu_informations.current_class as class',
                'reg_stu_informations.student_type',
                'ef.exam_name',
                'ef.reg_regular_fee',
                'ef.reg_irregular_jemni'
            )
            ->distinct() // ডুপ্লিকেট এন্ট্রি বাদ দেওয়া
            ->get();

        // ডিবাগিং - কোন ছাত্র কতবার আছে তা দেখার জন্য
        $studentCounts = [];
        foreach ($students as $student) {
            $studentId = $student->id;
            if (!isset($studentCounts[$studentId])) {
                $studentCounts[$studentId] = 0;
            }
            $studentCounts[$studentId]++;
        }

        // ক্লাস অনুযায়ী গ্রুপ করা - শুধু ইউনিক ছাত্রদের গণনা করা
        $classGroups = [];
        $countedStudents = []; // ইতিমধ্যে গণনা করা ছাত্রদের ট্র্যাক করা

        foreach ($students as $student) {
            $class = $student->class;
            $studentId = $student->id;

            if (!isset($classGroups[$class])) {
                $classGroups[$class] = [
                    'regular' => 0,
                    'irregular' => 0,
                    'exam_name' => $student->exam_name,
                    'reg_regular_fee' => $student->reg_regular_fee,
                    'reg_irregular_jemni' => $student->reg_irregular_jemni
                ];
            }

            // শুধুমাত্র এই ক্লাসে এই ছাত্রকে একবারই গণনা করা
            $key = $class . '_' . $studentId;
            if (!isset($countedStudents[$key])) {
                if ($student->student_type === 'নিয়মিত') {
                    $classGroups[$class]['regular']++;
                } else {
                    $classGroups[$class]['irregular']++;
                }
                $countedStudents[$key] = true;
            }
        }

        $result = [];

        // প্রতিটি ক্লাসের জন্য ফি তথ্য সংগ্রহ
        foreach ($classGroups as $class => $data) {
            $result[] = [
                'Marhala' => $class,
                'exam_name' => $data['exam_name'],
                'regularCount' => $data['regular'],
                'regularFee' => $data['reg_regular_fee'],
                'regularTotalFee' => $data['regular'] * $data['reg_regular_fee'],
                'irregularCount' => $data['irregular'],
                'irregularFee' => $data['reg_irregular_jemni'],
                'irregularTotalFee' => $data['irregular'] * $data['reg_irregular_jemni'],
                'totalAmount' => ($data['regular'] * $data['reg_regular_fee']) + ($data['irregular'] * $data['reg_irregular_jemni']),
                'studentCounts' => $studentCounts // ডিবাগিং তথ্য
            ];
        }

        return response()->json($result);
    }








    public function storePayment(Request $request)
    {
        $userId = $request->user()->id;
        $class = $request->class;
        $totalAmount = $request->total_amount;

        // reg_stu_informations টেবিল থেকে ছাত্রদের তথ্য নিয়ে আসা
        $students = DB::table('reg_stu_informations')
            ->where('user_id', $userId)
            ->where('current_class', $class)
            ->get();

        $insertedCount = 0;
        $updatedCount = 0;

        foreach ($students as $student) {
            // চেক করা যে ছাত্রের জন্য ইতিমধ্যে পেমেন্ট রেকর্ড আছে কিনা
            $existingPayment = DB::table('student_reg_payments')
                ->where('students_id', $student->id)
                ->first();

            if ($existingPayment) {
                // যদি রেকর্ড থাকে, তাহলে আপডেট করা
                $updated = DB::table('student_reg_payments')
                    ->where('students_id', $student->id)
                    ->update([
                        'payment_status' => 1, // পেমেন্ট করা হয়েছে
                        'updated_at' => now(),
                    ]);

                if ($updated) {
                    $updatedCount++;
                }
            } else {
                // যদি রেকর্ড না থাকে, তাহলে নতুন রেকর্ড তৈরি করা
                $inserted = DB::table('student_reg_payments')->insert([
                    'students_id' => $student->id,
                    'exam_id' => $student->exam_id,
                    'exam_name_Bn' => $student->exam_name_Bn ?? $student->exam_name ?? '',
                    'madrasha_id' => $student->madrasha_id,
                    'user_id' => $userId,
                    'class' => $student->current_class,
                    'student_type' => $student->student_type,
                    'payment_status' => 1, // পেমেন্ট করা হয়েছে
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($inserted) {
                    $insertedCount++;
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'পেমেন্ট সফলভাবে সম্পন্ন হয়েছে',
            'total_students' => $insertedCount + $updatedCount,
            'new_payments' => $insertedCount,
            'updated_payments' => $updatedCount,
            'total_amount' => $totalAmount
        ]);
    }





    public function checkPaymentStatus(Request $request)
    {
        $userId = $request->user()->id;

        // সব ক্লাসের পেমেন্ট স্ট্যাটাস নিয়ে আসা
        $paymentStatus = DB::table('reg_stu_informations as rsi')
            ->select('rsi.current_class as class',
                     DB::raw('COUNT(DISTINCT srp.students_id) as paid_count'),
                     DB::raw('COUNT(DISTINCT rsi.id) as total_count'))
            ->leftJoin('student_reg_payments as srp', function($join) {
                $join->on('rsi.id', '=', 'srp.students_id')
                     ->where('srp.payment_status', 1);
            })
            ->where('rsi.user_id', $userId)
            ->groupBy('rsi.current_class')
            ->get()
            ->map(function($item) {
                return [
                    'class' => $item->class,
                    'is_paid' => $item->paid_count > 0 && $item->paid_count >= $item->total_count
                ];
            });

        return response()->json($paymentStatus);
    }

    public function getUnpaidStudentsCount(Request $request)
    {
        $userId = $request->user()->id;
        $class = $request->query('class');

        // ক্লাস অনুযায়ী ইউনিক ছাত্রদের সংখ্যা গণনা
        $students = reg_stu_information::join('exam_fees as ef', 'reg_stu_informations.exam_id', '=', 'ef.exam_setup_id')
            ->where('reg_stu_informations.user_id', $userId)
            ->where('reg_stu_informations.current_class', $class)
            ->select(
                'reg_stu_informations.id',
                'reg_stu_informations.student_type',
                'ef.reg_regular_fee',
                'ef.reg_irregular_jemni'
            )
            ->distinct() // ডুপ্লিকেট এন্ট্রি বাদ দেওয়া
            ->get();

        // ইউনিক ছাত্রদের গণনা এবং ফি হিসাব
        $regularCount = 0;
        $irregularCount = 0;
        $regularFee = 0;
        $irregularFee = 0;
        $countedStudents = [];

        foreach ($students as $student) {
            $studentId = $student->id;

            // প্রতিটি ছাত্রকে একবারই গণনা করা
            if (!isset($countedStudents[$studentId])) {
                if ($student->student_type === 'নিয়মিত') {
                    $regularCount++;
                    $regularFee = $student->reg_regular_fee;
                } else {
                    $irregularCount++;
                    $irregularFee = $student->reg_irregular_jemni;
                }
                $countedStudents[$studentId] = true;
            }
        }

        // মোট পরিমাণ গণনা
        $totalAmount = ($regularCount * $regularFee) + ($irregularCount * $irregularFee);
        $totalCount = $regularCount + $irregularCount;

        return response()->json([
            'count' => $totalCount,
            'regular_count' => $regularCount,
            'irregular_count' => $irregularCount,
            'total_amount' => $totalAmount

        ]);
    }



    public function permission()
    {
        // Get the current admin user
        $admin = Auth::guard('admin')->user();

        // Load permissions for the admin
        $permissions = null;
        if ($admin) {
            $permissions = admin_permission::where('admin_id', $admin->id)->first();
            if ($permissions) {
                // Convert to array for easier access in the frontend
                $permissions = $permissions->toArray();
            }
        }

        // Attach permissions to the admin user object
        if ($admin) {
            $admin->permissions = $permissions;
        }

        return Inertia::render('admin/admin_Dashboard', [
            'auth' => [
                'admin' => $admin
            ]
        ]);
    }




}





