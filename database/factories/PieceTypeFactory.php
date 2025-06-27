<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PieceTypeFactory extends Factory
{
    protected $model = \App\Models\PieceType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
