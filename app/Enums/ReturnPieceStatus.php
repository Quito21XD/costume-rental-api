<?php

namespace App\Enums;

enum ReturnPieceStatus: string
{
    case GOOD = 'good';
    case MINOR_DAMAGE = 'minor_damage';
    case MODERATE_DAMAGE = 'moderate_damage';
    case SEVERE_DAMAGE = 'severe_damage';
    case LOST = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::GOOD => 'Bueno',
            self::MINOR_DAMAGE => 'Daño Menor',
            self::MODERATE_DAMAGE => 'Daño Moderado',
            self::SEVERE_DAMAGE => 'Daño Severo',
            self::LOST => 'Perdido',
        };
    }
}
