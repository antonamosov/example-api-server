<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrCreateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserServiceInterface;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function updateOrCreate(UpdateOrCreateUserRequest $request)
    {
        $user = $this->userService->updateOrCreate($request->all());

        return new UserResource($user);
    }
}
