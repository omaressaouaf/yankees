<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::create([
             'name' => "Omar Essaouaf" ,
             "email" => "omar@gmail.com",
             "phone" => "+212 6 23 98 23 08",
             "role" => 'admin',
             "password" => Hash::make('password')
         ]);
    }
}
