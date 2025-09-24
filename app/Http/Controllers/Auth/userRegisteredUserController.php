<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Services\UserRegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class UserRegisteredUserController extends Controller
{
    protected UserRegistrationService $userRegistrationService;

    public function __construct(UserRegistrationService $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    public function store(UserRegistrationRequest $request): RedirectResponse
    {
        $user = $this->userRegistrationService->register($request->validated(), $request);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}