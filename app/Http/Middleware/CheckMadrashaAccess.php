<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMadrashaAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the required session data exists
        if (!session()->has('madrasha_id') || !session()->has('custom_code')) {
            // For API response if it's an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'আপনাকে অবশ্যই আগে ইলহাক নম্বর এবং মোবাইল নম্বর দিয়ে যাচাই করতে হবে।',
                    'redirect' => route('madrasha_check_for_user')
                ], 403);
            }

            // For regular browser request
            return redirect()->route('madrasha_check_for_user')->with('error', 'আপনাকে অবশ্যই আগে ইলহাক নম্বর এবং মোবাইল নম্বর দিয়ে যাচাই করতে হবে।');
        }

        // Check if the session is fresh (created within the last 1 minute)
        if (session()->has('madrasha_verified_at')) {
            $verifiedAt = session('madrasha_verified_at');
            $now = now();

            // If more than 1 minute has passed since verification
            if ($now->diffInSeconds($verifiedAt) >= 1) {
                session()->forget(['madrasha_id', 'custom_code', 'madrasha_verified_at']);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'আপনার সেশন শেষ হয়ে গেছে। আবার যাচাই করুন।',
                        'redirect' => route('madrasha_check_for_user')
                    ], 403);
                }

                return redirect()->route('madrasha_check_for_user')
                    ->with('error', 'আপনার সেশন শেষ হয়ে গেছে। আবার যাচাই করুন।');
            }
        } else {
            // If madrasha_verified_at doesn't exist, add it now
            session(['madrasha_verified_at' => now()]);
        }

        return $next($request);
    }
}
