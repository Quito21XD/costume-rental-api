<?php

namespace Database\Factories;

use App\Enums\CostumeStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Costume>
 */
class CostumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'gender' => $this->faker->randomElement,
            'size' => $this->faker->randomElement(['xs', 's', 'm', 'l', 'xl']),
            'rental_price' => $this->faker->randomFloat(2, 10, 100),
            'status' => CostumeStatus::AVAILABLE,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
