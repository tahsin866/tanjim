<?php

namespace App\Http\Controllers;
use App\Models\admin\marhala_for_admin\ExamSetup;
use App\Models\schedule_setups;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleSetupController extends Controller
{
    //

    public function index()
    {
        $latestExam = ExamSetup::latest()->first();
        $schedules = schedule_setups::where('exam_setup_id', $latestExam->id)->get();

        return Inertia::render('central_Exam_setup/others_setup', [
            'examInfo' => $latestExam,
            'schedules' => $schedules
        ]);
    }




    public function store(Request $request)
    {
        $latestExam = ExamSetup::latest()->first();

        foreach ($request->formItems as $item) {
            schedule_setups::create([
                'exam_setup_id' => $latestExam->id,
                'schedule_type' => $item['label'],
                'start_date' => $item['startDate'],
                'end_date' => $item['endDate'],
                'is_active' => $item['isActive']
            ]);
        }

        return response()->json([
            'message' => 'Schedule setup updated successfully',
            'status' => 'success'
        ]);
    }

}
