<?php

namespace App\Models\admin\marhala_for_admin;

use Illuminate\Database\Eloquent\Model;

class ExamSetup extends Model
{
    protected $fillable = [
        'exam_name',
        'arabic_year',
        'bangla_year',
        'english_year',
        'status'
    ];

    public function examFees()
    {
        return $this->hasMany(ExamFee::class);
    }
}
