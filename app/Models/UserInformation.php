<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;

    protected $table = 'user_informations';

    protected $fillable = [
        'user_id',
        'alternatePhoneNumber',
        'dateOfBirth',
        'bloodGroup',
        'address',
        'division_id',
        'district_id',
        'thana_id',
        'classmate1',
        'classmate2',
        'classmate3',
        'dept_takmil',
        'dept_ifta',
        'dept_hifz',
        'dept_qirat',
        'dept_other',
        'dept_takmil_year_english',
        'dept_takmil_year_hijri',
        'dept_ifta_year_english',
        'dept_ifta_year_hijri',
        'dept_hifz_year_english',
        'dept_hifz_year_hijri',
        'dept_qirat_year_english',
        'dept_qirat_year_hijri',

        'dept_other_class',
        'examType',
        'rollNumber',
        'workplace',
        'idType',
        'birthCertificate',
        'voterId',
        'birthCertificatePhoto',
        'voterIdPhoto',
        'photo',
        'passport_id',
        'passport_photo'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}