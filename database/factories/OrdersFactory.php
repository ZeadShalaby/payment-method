<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Offers;
use App\Models\Payments;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'order_num' => $this->faker->unique()->randomNumber(2),
            'total_amount' => $this->faker->randomFloat(2, 50, 1000), // Total amount between 50 and 1000
            'user_id' => User::factory(), // Assuming you have a User model
            'offer_id' => Offers::factory(), // Assuming the Offers factory is already set up
            'payment_id' => Payments::factory(), // Example payment ID
            'price' => $this->faker->randomFloat(2, 10, 500), // Example price between 10 and 500

        ];
    }
}
