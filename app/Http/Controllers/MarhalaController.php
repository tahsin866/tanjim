<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\admin\marhala_for_admin\Marhala;
use App\Models\admin\marhala_for_admin\MarhalaSubject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MarhalaController extends Controller
{
    public function index()
    {
        $marhalas = Marhala::with('subjects')->get();
        return Inertia::render('Marhala/Index', [
            'marhalas' => $marhalas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'marhalaNameBn' => 'required|string',
            'marhalaNameEn' => 'required|string',
            'marhalaNameAr' => 'required|string',
            'subjects' => 'required|array'
        ]);

        $marhala = Marhala::create([
            'marhala_name_bn' => $request->marhalaNameBn,
            'marhala_name_en' => $request->marhalaNameEn,
            'marhala_name_ar' => $request->marhalaNameAr,
        ]);

        foreach ($request->subjects as $subject) {
            MarhalaSubject::create([
                'marhala_id' => $marhala->id,
                'subject_code' => $subject['code'],
                'name_bangla' => $subject['nameBangla'],
                'name_english' => $subject['nameEnglish'],
                'name_arabic' => $subject['nameArabic'],
                'status' => $subject['status']
            ]);
        }

        return redirect()->back()->with('success', 'Marhala created successfully');
    }


    public function edit(Marhala $marhala)
    {
        $marhalaData = $marhala->load('subjects');

        return Inertia::render('Mrahala_for_Admin/marhala_edit', [
            'marhala' => $marhalaData
        ]);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'marhalaNameBn' => 'required|string',
            'marhalaNameEn' => 'required|string',
            'marhalaNameAr' => 'required|string',
            'subjects' => 'required|array'
        ]);

        $marhala = Marhala::findOrFail($id);

        $marhala->update([
            'marhala_name_bn' => $request->marhalaNameBn,
            'marhala_name_en' => $request->marhalaNameEn,
            'marhala_name_ar' => $request->marhalaNameAr,
        ]);

        // পুরানো সব সাবজেক্ট ডিলিট করে নতুন করে ইনসার্ট করা হচ্ছে
        $marhala->subjects()->delete();

        foreach ($request->subjects as $subject) {
            MarhalaSubject::create([
                'marhala_id' => $marhala->id,
                'subject_code' => $subject['code'],
                'name_bangla' => $subject['nameBangla'],
                'name_english' => $subject['nameEnglish'],
                'name_arabic' => $subject['nameArabic'],
                'status' => $subject['status']
            ]);
        }

        return response()->json(['message' => 'Marhala updated successfully']);
    }







    public function fetchMarhalaWithCounts()
    {
        $marhalas = Marhala::select('id', 'marhala_name_bn')
            ->withCount([
                'subjects as total_subjects',
                'subjects as male_subjects' => function ($query) {
                    $query->where('status', 'SRtype_1');
                },
                'subjects as female_subjects' => function ($query) {
                    $query->where('status', 'SRtype_0');
                },
                'subjects as both_subjects' => function ($query) {
                    $query->where('status', 'both');
                },
            ])
            ->get();

        return response()->json($marhalas);
    }






    public function getSubjectMarhalaStats()
    {
        $marhalas = Marhala::select('id', 'marhala_name_bn')
            ->withCount([
                'subjects as total_subjects',
                'subjects as male_subjects' => function ($query) {
                    $query->where('status', 'SRtype_1');
                },
                'subjects as female_subjects' => function ($query) {
                    $query->where('status', 'SRtype_0');
                },
                'subjects as both_subjects' => function ($query) {
                    $query->where('status', 'both');
                },
            ])
            ->get();

        return response()->json($marhalas);
    }










}



