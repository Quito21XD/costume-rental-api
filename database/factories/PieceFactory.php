<?php

namespace Database\Factories;

use App\Models\PieceType;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Piece>
 */
class PieceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'replacement_cost' => $this->faker->randomFloat(2, 50, 1000),
            'material' => $this->faker->word,
            'color' => $this->faker->safeColorName,
            'piece_type_id' => PieceType::factory(), // Relación con PieceType
            'size_id' => Size::factory(), // Relación con Size
        ];
    }
}
