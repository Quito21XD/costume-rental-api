<?php

namespace App\Enums;

enum CostumePieceStatus: string
{
    case AVAILABLE = 'available';
    case RENTED = 'rented';
    case WITHDRAWN = 'withdrawn';
    case LOST = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Disponible',
            self::RENTED => 'Alquilado',
            self::WITHDRAWN => 'Retirado',
            self::LOST => 'Perdido',
        };
    }
}
