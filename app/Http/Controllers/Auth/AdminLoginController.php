<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm(): Response
    {
        return Inertia::render('admin/Login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $this->validator($request->all())->validate();

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            // Check if admin is active
            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Your account is inactive.'])->onlyInput('email');
            }

            // Generate JWT token for API calls (optional)
            $token = JWTAuth::fromUser($admin);
            
            // Store token in session for API usage if needed
            session(['admin_token' => $token]);

            // Redirect to dashboard instead of rendering - this ensures proper middleware pipeline
            return redirect()->route('admin.admin_Dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    /**
     * Handle admin logout request.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Get a validator for an incoming login request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
    }
}
