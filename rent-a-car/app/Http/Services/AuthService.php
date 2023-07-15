<?php

namespace app\Http\Services;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;



class AuthService
{
    public function login($email, $password ){
        $user = $this->getUserByCredentials($email, $password);
        if (!$user)
            return false;

        return $user->createToken('access_token')->plainTextToken;

    }

    private function getUserByCredentials($email, $password)
    {
        $user = User::query()->where('email', $email)
            ->first();

        if ($user && Hash::check($password, $user->password))
            return $user;
        else
            return null;
    }

    public function logout(){
        auth()->user()->tokens()->delete();
    }
}
