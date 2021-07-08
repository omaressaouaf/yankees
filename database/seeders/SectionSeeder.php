<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'name' => "about",
            'title_en' => "ENGLISH .Lorem, ipsum dolor sit amet consectetur adipisicing elit. ",
            "title_fr" => "FRENCH .Lorem, ipsum dolor sit amet consectetur adipisicing elit.",
            "content_en" => "ENGLISH .Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit.",
            "content_fr" => "FRENCH .Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit."
        ]);

    }
}
