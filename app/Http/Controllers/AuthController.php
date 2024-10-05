<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function register(SignupRequest $request)
    {
        return $this->authService->register($request);
    }
}
