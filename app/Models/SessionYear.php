<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionYear extends Model
{
    use HasFactory;

    protected $table = 'session_years';

    protected $fillable = [
        'english_year',
        'hijri_year',
        'hijri_start',
        'hijri_end'
    ];

    protected $casts = [
        'english_year' => 'integer',
        'hijri_start' => 'integer',
        'hijri_end' => 'integer'
    ];

    /**
     * Get hijri year by English year
     */
    public static function getHijriByEnglish($englishYear)
    {
        return self::where('english_year', $englishYear)->first();
    }

    /**
     * Get English year by hijri year
     */
    public static function getEnglishByHijri($hijriYear)
    {
        return self::where('hijri_start', '<=', $hijriYear)
                  ->where('hijri_end', '>=', $hijriYear)
                  ->first();
    }

    /**
     * Get current hijri year
     */
    public static function getCurrentHijri()
    {
        $currentYear = date('Y');
        return self::getHijriByEnglish($currentYear);
    }
}
