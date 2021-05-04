<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->tollFreePhoneNumber,
            "address_line" => $this->faker->address,
            "address_details" => $this->faker->streetName,
            "address_latitude" => $this->faker->latitude($min = -90, $max = 90),
            "address_longitude" => $this->faker->longitude($min = -180, $max = 180) ,
            "delivery_price" => $this->faker->randomDigit,
            "tax_price" => $this->faker->randomDigit,
            "total" => $this->faker->numberBetween($min = 10, $max = 500), // 8567,
            "status"=> $this->faker->randomElement(['pending' ,'processing', 'out_for_delivery' , 'delivered' , 'cancelled' , 'failed']),
            "created_at" => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)
        ];
    }
}
