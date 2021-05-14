<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @dataProvider versions */
    public function test_it_returns_all_categories($version, $status)
    {
        $this->seed(CategorySeeder::class);
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson("api/{$version}/categories");

        $response->assertStatus($status);
    }

    public function versions()
    {
        return [
            [1, 404,],
            [2, 200,]
        ];
    }
}
