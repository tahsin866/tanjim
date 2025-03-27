<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkazAgreement extends Model
{
    //
    protected $fillable = [
        'fazilat',
        'user_id',
        'user_name',
    'exam_id',
    'exam_name',
        'sanabiya_ulya',
        'sanabiya',
        'mutawassita',
        'ibtedaiyyah',
        'hifzul_quran',
        'noc_file',
        'resolution_file',
        'requirements',
        'muhtamim_consent',
        'president_consent',
        'committee_resolution',
        'status',
        'admin_feedback',
        'processed_at',
        'feedback_image',
        'submitted_at',
        'admin_name',
        'madrasha_id',
    ];

    // public function associatedMadrasas()
    // {
    //     return $this->hasMany(MarkazAgreementMadrasa::class);
    // }



    public function associatedMadrasas()
    {
        return $this->hasMany(MarkazAgreementMadrasa::class, 'markaz_agreement_id', 'id');
    }

    public function user()  // Changed from users() to user()
    {
        return $this->belongsTo(User::class);
    }


    public function activityLogs()
    {
        return $this->hasMany(activity_log::class, 'markaz_agreement_id'); // Assuming the foreign key is 'markaz_agreement_id'
    }


    public function schedule_setups()
    {
        return $this->belongsTo(schedule_setups::class, 'exam_setup_id'); // Assuming the foreign key is 'markaz_agreement_id'
    }


    public function regStuInformations()
    {
        return $this->hasMany(reg_stu_information::class, 'markaz_agreement_id');
    }



}
