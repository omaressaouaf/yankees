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
            'name' => "header",
            'title_en' => "Welcome to",
            "title_fr" => "Bienvenue au",
            "content_en" => "Providing great food for over 18 years!",
            "content_fr" => "Offrir de la bonne nourriture depuis plus de 18 ans!"
        ]);
        Section::create([
            'name' => "about",
            'title_en' => "ENGLISH .Lorem, ipsum dolor sit amet consectetur adipisicing elit. ",
            "title_fr" => "FRENCH .Lorem, ipsum dolor sit amet consectetur adipisicing elit.",
            "content_en" => "ENGLISH .Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit.",
            "content_fr" => "FRENCH .Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit.Lorem, ipsum dolor sit amet consectetur adipisicing elit."
        ]);

    }
}
