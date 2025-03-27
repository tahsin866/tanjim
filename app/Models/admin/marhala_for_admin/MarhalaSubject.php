<?php

namespace App\Models\admin\marhala_for_admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarhalaSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'marhala_id',
        'subject_code',
        'name_bangla',
        'name_english',
        'name_arabic',
        'status'
    ];

    public function marhala()
    {
        return $this->belongsTo(Marhala::class);

    }



    public function subjectSetting()
    {
        return $this->hasOne(subject_settings::class, 'subject_id');
    }
}
