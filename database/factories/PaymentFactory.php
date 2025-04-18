<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'method' => $this->faker->randomElement(['credit_card', 'paypal']),
            'status' => $this->faker->randomElement(['pending','success','failed']),
            'transaction_code' => $this->faker->uuid(),
            'paid_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
