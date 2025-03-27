<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class schedule_setups extends Model
{


    //
    protected $fillable = [
        'exam_setup_id',
        'schedule_type',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function examSetup()
    {
        return $this->belongsTo('App\Models\Admin\Marhala_for_admin\ExamSetup');
    }

    public function MarkazAgreement()
    {
        return $this->hasMany(MarkazAgreement::class, 'exam_id'); // Assuming the foreign key is 'markaz_agreement_id'
    }


}
