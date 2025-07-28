<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AdminPasswordResetOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    /**
     * Check if OTP is expired
     */
    public function isExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Check if OTP is valid (not expired and not used)
     */
    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }

    /**
     * Mark OTP as used
     */
    public function markAsUsed()
    {
        $this->update(['is_used' => true]);
    }

    /**
     * Generate a random 6-digit OTP
     */
    public static function generateOtp()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new OTP record for email
     */
    public static function createForEmail($email)
    {
        // Delete any existing unused OTPs for this email
        self::where('email', $email)->where('is_used', false)->delete();

        return self::create([
            'email' => $email,
            'otp' => self::generateOtp(),
            'expires_at' => Carbon::now()->addMinutes(10), // OTP expires in 10 minutes
            'is_used' => false,
        ]);
    }
}
