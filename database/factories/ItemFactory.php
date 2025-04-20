<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::first()->id, // ini akan diganti di seeder
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->randomElement(['baju', 'elektronik', 'mainan']),
            'condition' => $this->faker->randomElement(['layak', 'rusak ringan', 'rusak berat']),
            'location' => $this->faker->word(),
        ];
    }
}
