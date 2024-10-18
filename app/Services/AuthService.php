<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use ResponseTrait;
    public function login($request)
    {
        try
        {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->responseError(null,'Invalid credentials',Response::HTTP_UNAUTHORIZED);
            }
            $user['token'] = $user->createToken('url-shortener')->plainTextToken;

            return $this->responseSuccess(UserResource::make($user),"Login successfully!");
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }

    public function register($request)
    {
        try
        {
            $data  = $request->validated();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $user['token'] = $user->createToken('url-shortener')->plainTextToken;
            return $this->responseSuccess(UserResource::make($user),"Register successfully!");
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }

    public function logout()
    {
        try
        {
            auth()->user()->tokens()->delete();
            return $this->responseSuccess([],"Logout successfully done!");
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }
}
