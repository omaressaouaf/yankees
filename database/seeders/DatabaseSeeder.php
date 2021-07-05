<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MealSeeder;
use Database\Seeders\ExtraSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        // $this->call(MealSeeder::class);
        // $this->call(ExtraSeeder::class);
        $this->call(SectionSeeder::class);

    }
}
