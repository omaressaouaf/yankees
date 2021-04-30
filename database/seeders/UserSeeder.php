<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $adminRole = Role::create(['name' => "admin", 'label' => "Admin"]);
        Role::create(['name' => "deliveryman", 'label' => "Delivery man"]);
        Role::create(['name' => "client", 'label' => "Client"]);
        $user = User::create([
            'name' => "Omar Essaouaf",
            "email" => "omar@gmail.com",
            "phone" => "+212 6 23 98 23 08",
            "password" => Hash::make('password')
        ]);
        $user->roles()->attach($adminRole);

    }
}
