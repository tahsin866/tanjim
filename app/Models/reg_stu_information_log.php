<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class reg_stu_information_log extends Model
{

    use HasFactory;

    protected $fillable = [
        'reg_student_id',
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
    ];

    /**
     * Get the student information that owns the log.
     */
    public function studentInformation()
    {
        return $this->belongsTo(reg_stu_information::class, 'reg_student_id');
    }

    /**
     * Get the admin user associated with the log.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the regular user associated with the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
