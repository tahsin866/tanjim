<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{


    protected $table = 'district';
    protected $fillable = ['Des_ID', 'District_U', 'DID'];


    public function division()
    {
        return $this->belongsTo(division::class); // Assuming the foreign key is 'markaz_agreement_id'
    }


    public function Thana()
    {
        return $this->hasMany(Thana::class); // Assuming the foreign key is 'markaz_agreement_id'
    }

}
