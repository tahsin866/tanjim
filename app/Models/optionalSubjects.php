<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\marhala_for_admin\MarhalaSubject;


class optionalSubjects extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'marhala_id',
        'subject_code',
        'name_bangla',
        'is_selected'
    ];

    /**
     * Get the user that owns the optional subject selection.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the marhala that this optional subject belongs to.
     */
    public function marhala()
    {
        return $this->belongsTo(MarhalaSubject::class, 'marhala_id', 'marhala_id');
    }


}
