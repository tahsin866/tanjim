<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{

    protected $table = 'division';
    protected $fillable = ['id', 'divisionUni'];

    public function District()
    {
        return $this->hasMany(District::class, 'DID'); // Assuming the foreign key is 'markaz_agreement_id'
    }


    public function division()
    {
        return $this->belongsTo(division::class); // Assuming the foreign key is 'markaz_agreement_id'
    }


}
