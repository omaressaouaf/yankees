<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meal::factory()
            ->count(3)
            ->for(Category::factory())
            ->create();
        Meal::factory()
            ->count(5)
            ->for(Category::factory())
            ->create();
        Meal::factory()
            ->count(2)
            ->for(Category::factory())
            ->create();

    }
}
