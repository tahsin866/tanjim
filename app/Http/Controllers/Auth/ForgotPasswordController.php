<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showEmailForm()
    {
        return Inertia::render('Auth/ForgotPassword/EmailForm');
    }

    /**
     * Send OTP to email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'ইমেইল ঠিকানা প্রয়োজন।',
            'email.email' => 'সঠিক ইমেইল ঠিকানা দিন।',
            'email.exists' => 'এই ইমেইল ঠিকানা দিয়ে কোনো অ্যাকাউন্ট নেই।',
        ]);

        // Check if user is suspended
        $user = User::where('email', $request->email)->first();
        if ($user->status === User::STATUS_SUSPENDED) {
            return back()->withErrors([
                'email' => 'আপনার অ্যাকাউন্ট সাসপেন্ড করা হয়েছে। পাসওয়ার্ড রিসেট করা যাবে না।'
            ]);
        }

        try {
            // Create OTP
            $otpRecord = PasswordResetOtp::createForEmail($request->email);

            // Send email (you can customize this email template)
            Mail::send('emails.password-reset-otp', [
                'otp' => $otpRecord->otp,
                'user' => $user
            ], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('পাসওয়ার্ড রিসেট OTP - তানযিমে আবনায়ে ফরিদাবাদ');
            });

            return redirect()->route('password.verify-otp', ['email' => $request->email])
                           ->with('success', 'আপনার ইমেইলে একটি OTP পাঠানো হয়েছে।');

        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'ইমেইল পাঠাতে সমস্যা হয়েছে। আবার চেষ্টা করুন।'
            ]);
        }
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return Inertia::render('Auth/ForgotPassword/OtpForm', [
            'email' => $email
        ]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ], [
            'email.required' => 'ইমেইল ঠিকানা প্রয়োজন।',
            'otp.required' => 'OTP প্রয়োজন।',
            'otp.size' => 'OTP অবশ্যই ৬ ডিজিটের হতে হবে।',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
                                   ->where('otp', $request->otp)
                                   ->where('is_used', false)
                                   ->first();

        if (!$otpRecord) {
            return back()->withErrors([
                'otp' => 'ভুল OTP। আবার চেষ্টা করুন।'
            ]);
        }

        if ($otpRecord->isExpired()) {
            return back()->withErrors([
                'otp' => 'OTP এর মেয়াদ শেষ। নতুন OTP এর জন্য আবার চেষ্টা করুন।'
            ]);
        }

        // Mark OTP as used
        $otpRecord->markAsUsed();

        return redirect()->route('password.reset-form', ['email' => $request->email])
                       ->with('success', 'OTP যাচাই সফল। এখন নতুন পাসওয়ার্ড সেট করুন।');
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return Inertia::render('Auth/ForgotPassword/ResetForm', [
            'email' => $email
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'email.required' => 'ইমেইল ঠিকানা প্রয়োজন।',
            'password.required' => 'পাসওয়ার্ড প্রয়োজন।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
        ]);

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Delete all unused OTPs for this email
        PasswordResetOtp::where('email', $request->email)->delete();

        return redirect()->route('login')
                       ->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে। এখন লগইন করুন।');
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Check rate limiting (optional)
        $recentOtp = PasswordResetOtp::where('email', $request->email)
                                   ->where('created_at', '>=', now()->subMinute())
                                   ->first();

        if ($recentOtp) {
            return back()->withErrors([
                'email' => 'অনুগ্রহ করে ১ মিনিট অপেক্ষা করুন নতুন OTP এর জন্য।'
            ]);
        }

        try {
            $user = User::where('email', $request->email)->first();
            $otpRecord = PasswordResetOtp::createForEmail($request->email);

            Mail::send('emails.password-reset-otp', [
                'otp' => $otpRecord->otp,
                'user' => $user
            ], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('পাসওয়ার্ড রিসেট OTP - তানযিমে আবনায়ে ফরিদাবাদ');
            });

            return back()->with('success', 'নতুন OTP পাঠানো হয়েছে।');

        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'ইমেইল পাঠাতে সমস্যা হয়েছে। আবার চেষ্টা করুন।'
            ]);
        }
    }
}
