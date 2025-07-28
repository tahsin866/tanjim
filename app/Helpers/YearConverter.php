<?php

namespace App\Helpers;

use App\Models\SessionYear;

class YearConverter
{
    /**
     * Convert English year to Hijri year
     */
    public static function englishToHijri($englishYear)
    {
        $sessionYear = SessionYear::getHijriByEnglish($englishYear);
        return $sessionYear ? $sessionYear->hijri_year : null;
    }

    /**
     * Convert Hijri year to English year
     */
    public static function hijriToEnglish($hijriYear)
    {
        $sessionYear = SessionYear::getEnglishByHijri($hijriYear);
        return $sessionYear ? $sessionYear->english_year : null;
    }

    /**
     * Get current hijri year
     */
    public static function getCurrentHijri()
    {
        $currentYear = date('Y');
        return self::englishToHijri($currentYear);
    }

    /**
     * Get current English year
     */
    public static function getCurrentEnglish()
    {
        return date('Y');
    }

    /**
     * Get year range for dropdown/select
     */
    public static function getYearRange($startYear = 1950, $endYear = null)
    {
        if (!$endYear) {
            $endYear = date('Y') + 5; // 5 years in future
        }

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $hijri = self::englishToHijri($year);
            $years[] = [
                'english' => $year,
                'hijri' => $hijri,
                'display' => $hijri ? "$year ($hijri)" : "$year"
            ];
        }

        return $years;
    }

    /**
     * Format year display with both English and Hijri
     */
    public static function formatYearDisplay($englishYear)
    {
        $hijri = self::englishToHijri($englishYear);
        return $hijri ? "$englishYear ($hijri)" : "$englishYear";
    }
}
