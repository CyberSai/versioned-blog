<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

/** @version 1 */
class UserController extends Controller
{
    public function index(int $version)
    {
        $users = User::query()->latest()->simplePaginate();

        return UserResource::collection($users);
    }

    public function store(int $version, UserStoreRequest $request)
    {
        $user = User::query()->forceCreate($request->validated());

        return new UserResource($user->refresh());
    }

    public function show(int $version, User $user)
    {
        return new UserResource($user);
    }
}
