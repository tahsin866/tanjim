<?php

namespace App\Http\Controllers;
use App\Models\admin\marhala_for_admin\MarhalaSubject;
use App\Models\admin\marhala_for_admin\subject_settings;
use App\Models\optionalSubjects;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class MarhalaListController extends Controller
{


    public function getsubjectForMadrasha($marhalaId)
    {
        return Inertia::render('Markaz/subjectSetting_list', [
            'marhalaId' => $marhalaId
        ]);
    }


public function getSubjects($marhalaId)
{
    // Get subjects from subject_settings table for the given marhala_id
    $subjects = subject_settings::where('marhala_id', $marhalaId)
        ->select('id', 'Subject_Names as name', 'syllabus_type', 'subject_id')
        ->get();

    // Filter mandatory subjects
    $mandatorySubjects = $subjects->filter(function ($subject) {
        return $subject->syllabus_type === 'আবশ্যিক';
    })->map(function ($subject) {
        // Get subject code from marhala_subjects table using subject_id
        $subjectCode = MarhalaSubject::where('id', $subject->subject_id)
            ->value('subject_code');

        return [
            'id' => $subject->id,
            'name' => $subject->name,
            'code' => $subjectCode ?? '', // Use subject code or empty string if not found
            'syllabus_type' => $subject->syllabus_type,
        ];
    })->values();

    // Filter optional subjects
    $optionalSubjects = $subjects->filter(function ($subject) {
        return $subject->syllabus_type === 'নৈর্বাচনিক';
    })->map(function ($subject) {
        // Get subject code from marhala_subjects table using subject_id
        $subjectCode = MarhalaSubject::where('id', $subject->subject_id)
            ->value('subject_code');

        return [
            'id' => $subject->id,
            'name' => $subject->name,
            'code' => $subjectCode ?? '', // Use subject code or empty string if not found
            'syllabus_type' => $subject->syllabus_type,
        ];
    })->values();

    // Return the response
    return response()->json([
        'mandatorySubjects' => $mandatorySubjects,
        'optionalSubjects' => $optionalSubjects,
    ]);
}





// =====================================================================


public function saveSubjectSelection(Request $request)
{
    $validated = $request->validate([
        'marhalaId' => 'required',
        'selectedSubjects' => 'required|array',
        'selectedSubjects.*' => 'string',
        'previousSelection' => 'nullable|string'
    ]);

    $user = Auth::user();
    $marhalaId = $validated['marhalaId'];
    $previousSelection = $validated['previousSelection'] ?? null;

    // First, unselect all previously selected optional subjects for this user and marhala
    optionalSubjects::where('user_id', $user->id)
        ->where('marhala_id', $marhalaId)
        ->where('is_selected', 1)
        ->update(['is_selected' => 0]);

    // Get the selected subject details
    foreach ($validated['selectedSubjects'] as $subjectCode) {
        // Find the subject details from marhala_subjects table
        $subject = MarhalaSubject::where('subject_code', $subjectCode)
            ->where('marhala_id', $marhalaId)
            ->first();

        if ($subject) {
            // Create or update the optional subject selection
            optionalSubjects::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'marhala_id' => $marhalaId,
                    'subject_code' => $subjectCode,
                ],
                [
                    'name_bangla' => $subject->name_bangla ?? $subject->name ?? '',
                    'is_selected' => 1  // Mark as selected
                ]
            );
        }
    }

    return response()->json([
        'message' => 'বিষয় নির্বাচন সফলভাবে সংরক্ষণ করা হয়েছে।',
        'status' => 'success'
    ]);
}



public function getUserSubjectSelection($marhalaId)
{
    $user = Auth::user();

    $selection = optionalSubjects::where('user_id', $user->id)
        ->where('marhala_id', $marhalaId)
        ->where('is_selected', 1)
        ->first();

    return response()->json([
        'selection' => $selection
    ]);
}








}

