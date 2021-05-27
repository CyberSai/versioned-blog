<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryTest extends TestCase
{
    public function test_category_has_many_posts()
    {
        $category = Category::factory()->has(Post::factory()->count(5))->make();

        $this->assertInstanceOf(Collection::class, $category->posts);
    }
}
