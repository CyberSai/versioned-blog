<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_posts_for_a_user()
    {
        Post::factory()->count(5)->create();
        $user = User::factory()->has(Post::factory()->count(3))->create();

        $response = $this->actingAs($user, 'api')->getJson("api/1/users/{$user->id}/posts");

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_store_creates_new_post_belonging_to_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson("api/1/users/{$user->id}/posts", Post::factory()->raw());

        $response->assertCreated();
    }

    public function test_show_returns_posts_belonging_to_user()
    {
        $post = Post::factory()->create();

        $response = $this->actingAs($post->user, 'api')->getJson("api/1/posts/{$post->id}");

        $response->assertOk();
    }
}
