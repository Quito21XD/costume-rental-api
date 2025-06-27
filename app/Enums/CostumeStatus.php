<?php

namespace App\Enums;

enum CostumeStatus: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case INCOMPLETE = 'incomplete';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Disponible',
            self::UNAVAILABLE => 'No disponible',
            self::INCOMPLETE => 'Incompleto',
        };
    }
}
