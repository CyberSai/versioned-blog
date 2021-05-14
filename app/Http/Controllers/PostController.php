<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

/** @version 1 */
class PostController extends Controller
{
    public function index(int $version, User $user)
    {
        $posts = $user->posts()->latest()->paginate();

        return PostResource::collection($posts);
    }

    public function store(int $version, User $user, PostStoreRequest $request)
    {
        $post = $user->posts()->create($request->validated());

        return new PostResource($post);
    }

    public function show(int $version, Post $post)
    {
        abort_unless($post->user->id === auth()->id(), 403, "You are not the owner of the Post");

        return new PostResource($post);
    }

    public function update(int $version, Request $request, Post $post)
    {
        //
    }

    public function destroy(int $version, Post $post)
    {
        //
    }
}
