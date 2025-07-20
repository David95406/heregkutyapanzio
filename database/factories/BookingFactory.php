<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('now', '+2 weeks'),
            'end_date' => fake()->dateTimeBetween('+2 weeks', '+4 weeks'),
            'accepted' => null,
            'verification_token' => fake()->uuid(),
            'verified_at' => null,
        ];
    }
}
