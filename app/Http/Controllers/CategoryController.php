<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(int $version)
    {
        abort_unless($version >= 2, 404, 'Not Found');

        $categories = Category::query()->latest()->paginate();

        return CategoryResource::collection($categories);
    }
}
