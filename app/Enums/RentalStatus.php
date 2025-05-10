<?php

namespace App\Enums;

enum RentalStatus: string
{
    case RENTED = 'rented';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::RENTED => 'Alquilado',
            self::COMPLETED => 'Completado',
        };
    }
}
