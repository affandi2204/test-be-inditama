<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $service = $this->userService->register($request);
        return $service;
    }

    public function login (Request $request)
    {
        $service = $this->userService->login($request);
        return $service;
    }

    public function logout ()
    {
        $service = $this->userService->logout();
        return $service;
    }

    public function profile ()
    {
        $service = $this->userService->profile();
        return $service;
    }
}
