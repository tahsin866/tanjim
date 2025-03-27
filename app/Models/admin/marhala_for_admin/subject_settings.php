<?php

namespace App\Models\admin\marhala_for_admin;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class subject_settings extends Model
{

    protected $table = 'subject_settings';

    protected $fillable = [
        'marhala_id',
        'subject_id',
        'Marhala_type',
        'Subject_Names',
        'student_type',
        'syllabus_type',
        'markaz_type',
        'subject_type',
        'total_marks',
        'pass_marks',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function marhala()
    {
        return $this->belongsTo(Marhala::class);
    }

    public function subject()
    {
        return $this->belongsTo(MarhalaSubject::class, 'subject_id');
    }


    public function MarhalaSubject()
    {
        return $this->belongsTo(MarhalaSubject::class, 'subject_id', 'id');
    }


}
