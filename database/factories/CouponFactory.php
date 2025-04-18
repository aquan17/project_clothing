<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->word(),
            'discount_type' => $this->faker->randomElement(['percentage', 'fixed']),
            'discount_value' => $this->faker->randomFloat(2, 5, 30),
            'start_date' => $this->faker->dateTimeThisYear(),
            'end_date' => $this->faker->dateTimeThisYear('+1 month'),
            'usage_limit' => $this->faker->numberBetween(1, 100),
            'used_count' => $this->faker->numberBetween(0, 50),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
