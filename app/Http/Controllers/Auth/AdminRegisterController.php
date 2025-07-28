<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminRegisterController extends Controller
{
    /**
     * Show the admin registration form.
     */
    public function showRegistrationForm(): Response
    {
        return Inertia::render('admin/Register');
    }

    /**
     * Handle admin registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        $admin = $this->create($request->all());

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.admin_Dashboard')->with('success', 'Admin registration successful!');

    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string', 'in:super_admin,admin,moderator'],
            'department' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'permissions' => ['nullable', 'array'],
        ]);
    }

    /**
     * Create a new admin instance after a valid registration.
     */
    protected function create(array $data): Admin
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'moderator',
            'department' => $data['department'] ?? null,
            'designation' => $data['designation'] ?? null,
            'phone' => $data['phone'] ?? null,
            'permissions' => $data['permissions'] ?? [],
            'is_active' => true,
            'created_by' => null, // First admin won't have creator
        ]);
    }
}
