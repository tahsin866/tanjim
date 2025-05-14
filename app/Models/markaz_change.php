<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\admin\marhala_for_admin\ExamSetup;
class markaz_change extends Model
{



    protected $table = 'markaz_changes';

    protected $fillable = [
        'user_id',
        'central_exam_id',
        'madrasha_id',
        'markaz_id',
        'madrasha_name',
        'asking_madrasha',
        'markaz_type',
        'onapotti_potro',
        'shommoti_potro',
        'madrasha_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examSetup()
    {
        return $this->belongsTo(ExamSetup::class, 'central_exam_id');
    }

    public function madrasha()
    {
        return $this->belongsTo(Madrasha::class);
    }





}
