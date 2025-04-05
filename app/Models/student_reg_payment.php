<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_reg_payment extends Model
{
    



    public function student()
    {
        return $this->belongsTo(reg_stu_information::class, 'students_id', 'id');
    }
}
