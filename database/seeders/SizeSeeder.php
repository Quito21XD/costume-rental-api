<?php

namespace Database\Seeders;

use App\Models\PieceType;
use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizesByType = [
            'Sombrero' => ['S', 'M', 'L'],
            'Camisa' => ['36', '38', '40', '42'],
            'Pantalón' => ['28', '30', '32', '34', '36'],
            'Falda' => ['1', '2', '3', '4'],
            'Zapatos' => ['37', '38', '39', '40', '41'],
            'Cinta' => ['Niño', 'Adolescente', 'Adulto'],
            'Chaleco' => ['S', 'M', 'L', 'XL'],
            'Blusa' => ['S', 'M', 'L'],
            'Accesorio' => ['no aplica'],
        ];

        foreach ($sizesByType as $typeName => $sizes) {
            $pieceType = PieceType::where('name', $typeName)->first();

            if ($pieceType) {
                foreach ($sizes as $size) {
                    Size::create([
                        'name' => $size,
                        'piece_type_id' => $pieceType->id,
                    ]);
                }
            }
        }
    }
}
