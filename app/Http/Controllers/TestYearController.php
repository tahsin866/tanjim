<?php

namespace App\Http\Controllers;

use App\Models\SessionYear;
use App\Helpers\YearConverter;
use Illuminate\Http\Request;

class TestYearController extends Controller
{
    /**
     * Test year conversion functionality
     */
    public function index()
    {
        // Get some sample data
        $sampleYears = SessionYear::take(10)->get();

        // Test conversions
        $currentHijri = YearConverter::getCurrentHijri();
        $currentEnglish = YearConverter::getCurrentEnglish();

        // Test specific conversions
        $test2025Hijri = YearConverter::englishToHijri(2025);
        $test1400English = YearConverter::hijriToEnglish(1400);

        // Get year range for dropdown
        $yearRange = YearConverter::getYearRange(2020, 2030);

        return response()->json([
            'success' => true,
            'sample_data' => $sampleYears,
            'current_hijri' => $currentHijri,
            'current_english' => $currentEnglish,
            'test_2025_to_hijri' => $test2025Hijri,
            'test_1400_to_english' => $test1400English,
            'year_range_sample' => $yearRange,
            'total_records' => SessionYear::count(),
            'message' => 'SessionYear table এবং YearConverter helper সফলভাবে কাজ করছে!'
        ]);
    }

    /**
     * Get all session years
     */
    public function getAllYears()
    {
        $years = SessionYear::orderBy('english_year')->get();

        return response()->json([
            'success' => true,
            'data' => $years,
            'total' => $years->count()
        ]);
    }

    /**
     * Convert specific year
     */
    public function convertYear(Request $request)
    {
        $englishYear = $request->input('english_year');
        $hijriYear = $request->input('hijri_year');

        $result = [];

        if ($englishYear) {
            $result['hijri'] = YearConverter::englishToHijri($englishYear);
            $result['formatted'] = YearConverter::formatYearDisplay($englishYear);
        }

        if ($hijriYear) {
            $result['english'] = YearConverter::hijriToEnglish($hijriYear);
        }

        return response()->json([
            'success' => true,
            'input' => $request->all(),
            'result' => $result
        ]);
    }
}
