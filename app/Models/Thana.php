<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{

    protected $table = 'thana';
    protected $fillable = ['id', 'Thana_U', 'Des_ID'];



    public function District()
    {
        return $this->belongsTo(District::class); // Assuming the foreign key is 'markaz_agreement_id'
    }




}
