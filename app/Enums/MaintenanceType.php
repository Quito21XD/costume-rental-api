<?php

namespace App\Enums;

enum MaintenanceType: string
{
    case CLEANING = 'cleaning';
    case MINOR_REPAIR = 'minor_repair';
    case MODERATE_REPAIR = 'moderate_repair';
    case RETIRED = 'retired';

    public function label(): string
    {
        return match ($this) {
            self::CLEANING => 'Limpieza',
            self::MINOR_REPAIR => 'Reparación Menor',
            self::MODERATE_REPAIR => 'Reparación Moderada',
            self::RETIRED => 'Retirado',
        };
    }
}
