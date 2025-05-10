<?php

namespace App\Enums;

enum CostumeStatus: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case INCOMPLETE = 'incomplete';

    public static function getStatusLabel(string $status): string
    {
        return match ($status) {
            self::AVAILABLE => 'Disponible',
            self::UNAVAILABLE => 'No disponible',
            self::INCOMPLETE => 'Incompleto',
        };
    }
}
