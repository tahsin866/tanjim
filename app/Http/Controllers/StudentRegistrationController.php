<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Services\StudentService;

class StudentRegistrationController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Show student data for logged-in user
     */
    public function studentData()
    {
        $userId = Auth::id();

        return Inertia::render('madrashaDashboard/studentData', [
            'students'  => $this->studentService->getStudentData($userId),
            'divisions' => $this->studentService->getDivisions(),
            'districts' => $this->studentService->getDistricts(),
            'thanas'    => $this->studentService->getThanas(),
        ]);
    }

    /**
     * Show the edit page for a single student
     */
    public function editStudentPage(User $student)
    {
        return Inertia::render('madrashaDashboard/StudentEdit', [
            'student'   => $this->studentService->getSingleStudent($student->id),
            'divisions' => $this->studentService->getDivisions(),
            'districts' => $this->studentService->getDistricts(),
            'thanas'    => $this->studentService->getThanas(),
        ]);
    }

    /**
     * Update student information
     */
    public function updateStudent(Request $request, $id)
    {
        $this->studentService->updateStudent($request, $id);

        return redirect()->back()->with('success', 'শিক্ষার্থীর তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Show detailed information of a student
     */
    public function studentDetails($id)
    {
        return Inertia::render('madrashaDashboard/StudentDetails', [
            'student'   => $this->studentService->getStudentDetails($id),
            'divisions' => $this->studentService->getDivisions(),
            'districts' => $this->studentService->getDistricts(),
            'thanas'    => $this->studentService->getThanas(),
        ]);
    }

    /**
     * Return student statistics for dashboard API
     */
    public function studentStats(Request $request)
    {
        return response()->json($this->studentService->getStudentStats());
    }
}
