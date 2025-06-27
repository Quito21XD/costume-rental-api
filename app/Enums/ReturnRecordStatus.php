<?php

namespace App\Enums;

enum ReturnRecordStatus: string
{
    case PENDING_REVIEW = 'pending_review';
    case PENDING_MAINTENANCE = 'pending_maintenance';
    case PENDING_PAYMENT = 'pending_payment';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_REVIEW => 'Pendiente de Revisión',
            self::PENDING_MAINTENANCE => 'Pendiente de Mantenimiento',
            self::PENDING_PAYMENT => 'Pendiente de Pago',
            self::COMPLETED => 'Completado',
        };
    }
}
