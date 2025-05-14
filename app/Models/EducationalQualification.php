<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalQualification extends Model
{
    protected $table = 'educational_qualifications';




    protected $fillable = [
        'application_id',
        'class_name',
        'pass_year',
        'result',
        'institution',

    ];


  public function application()
    {
        return $this->belongsTo(NegMumtahinAplication::class, 'application_id', 'id');
    }

}
