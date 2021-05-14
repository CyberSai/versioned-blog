<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()->updateOrCreate(['name' => 'General']);
        Category::query()->updateOrCreate(['name' => 'Database']);
        Category::query()->updateOrCreate(['name' => 'UI/UX']);
        Category::query()->updateOrCreate(['name' => 'Back-end']);
        Category::query()->updateOrCreate(['name' => 'Front-end']);
    }
}
