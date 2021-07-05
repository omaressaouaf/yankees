<?php

namespace Database\Seeders;

use App\Models\Order;
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
        /**  Roles */
        $adminRole = Role::create(['name' => "admin", 'label' => "Admin"]);
        $managerRole = Role::create(['name' => "manager", 'label' => "Manager"]);
        $deliverymanRole = Role::create(['name' => "deliveryman", 'label' => "Delivery man"]);
        $clientRole =  Role::create(['name' => "client", 'label' => "Client"]);
        /**  Main Users */
        $admin = User::create([
            'name' => "Admin",
            "email" => "admin@gmail.com",
            "phone" => "+212 6 23 98 23 08",
            "password" => Hash::make('password')
        ]);
        $manager = User::create([
            'name' => "Manager",
            "email" => "manager@gmail.com",
            "phone" => "+212 6 23 98 23 08",
            "password" => Hash::make('password')
        ]);
        $deliveryman = User::create([
            'name' => "Deliveryman",
            "email" => "deliveryman@gmail.com",
            "phone" => "+212 6 23 98 23 08",
            "password" => Hash::make('password')
        ]);

        /**  attaching roles to main users */
        $admin->roles()->attach($adminRole);
        $manager->roles()->attach($managerRole);
        $deliveryman->roles()->attach($deliverymanRole);

        /** Fake users with roles */
        $adminRole->users()->attach(User::factory()
            ->count(2)
            ->create());
        $managerRole->users()->attach(User::factory()
            ->count(4)
            ->create());
        $deliverymanRole->users()->attach(User::factory()
            ->count(10)
            ->create());
        $clientRole->users()->attach(User::factory()
            ->count(50)
            ->create());

        /** Fake orders for main users */
        Order::factory()
            ->hasMeals(3)
            ->for($admin)
            ->count(40)
            ->create();
        Order::factory()
            ->hasMeals(3)
            ->for($deliveryman)
            ->count(40)
            ->create();
    }
}
