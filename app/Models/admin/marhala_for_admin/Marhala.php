<?php

namespace App\Models\admin\marhala_for_admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marhala extends Model
{

    use HasFactory;

    protected $fillable = [
        'marhala_name_bn',
        'marhala_name_en',
        'marhala_name_ar'
    ];

    public function subjects()
    {
        return $this->hasMany(MarhalaSubject::class);
    }

    // public function subjects_1()
    // {
    //     return $this->hasMany(MarhalaSubject::class, 'marhala_id');
    // }


}
