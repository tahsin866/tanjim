<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class activity_log extends Model
{


protected $fillable =[

'markaz_agreement_id',
'admin_id',
'user_id',
'status',
'actor_type',
'admin_name',
'user_name',
'user_position',
'admin_position',
'admin_message',
'admin_feedback_image',
'created_at',
'updated_at',


];








    public function MarkazAgreement()  // Changed from users() to user()
    {
        return $this->belongsTo(MarkazAgreement::class);
    }

    public function user()  // Changed from users() to user()
    {
        return $this->belongsTo(user::class);
    }


    public function admin()  // Changed from users() to user()
    {
        return $this->belongsTo(admin::class);
    }
}
