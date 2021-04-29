<?php

namespace Database\Seeders;

use App\Models\Extra;
use Illuminate\Database\Seeder;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Extra::factory()
            ->hasOptions(3)
            ->create();
        Extra::factory()
            ->hasOptions(2)
            ->create();
        Extra::factory()
            ->hasOptions(8)
            ->create();
    }
}
