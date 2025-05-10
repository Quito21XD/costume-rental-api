<?php

namespace Database\Seeders;

use App\Models\PieceType;
use Illuminate\Database\Seeder;

class PieceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Sombrero',
            'Camisa',
            'Pantalón',
            'Falda',
            'Zapatos',
            'Cinta',
            'Chaleco',
            'Blusa',
            'Accesorio',
        ];

        foreach ($types as $type) {
            PieceType::create(['name' => $type]);
        }
    }
}
