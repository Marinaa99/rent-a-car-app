<?php

namespace app\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    public function register(RegistrationRequest $request){
        return  User::query()->create($request->validated());
    }
}
