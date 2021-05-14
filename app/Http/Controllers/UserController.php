<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(int $version)
    {
        $users = User::query()->paginate();

        return UserResource::collection($users);
    }

    public function store(int $version, UserStoreRequest $request)
    {
        ($user = new User)->forceFill($request->validated())->save();

        return new UserResource($user->refresh());
    }

    public function show(int $version, User $user)
    {
        return new UserResource($user);
    }
}
