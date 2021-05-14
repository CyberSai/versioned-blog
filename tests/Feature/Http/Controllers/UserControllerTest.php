<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_users()
    {
        $users = User::factory()->count(5)->create();

        $response = $this->actingAs($users[0], 'api')->getJson('api/1/users');

        $response->assertOk()->assertJsonCount(5, 'data');
    }

    public function test_store_creates_new_users()
    {
        $response = $this->postJson('api/1/users', User::factory()->raw());

        $response->assertCreated();
    }

    public function test_show_returns_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson("api/1/users/{$user->id}");

        $response->assertOk();
    }
}
