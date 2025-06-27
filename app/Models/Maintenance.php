<?php

namespace App\Models;

use App\Enums\MaintenanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Api
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;

    protected $fillable = [
        'returned_piece_id',
        'maintenance_type',
        'cost',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'maintenance_type' => MaintenanceType::class,
    ];

    public function returnedPiece(): BelongsTo
    {
        return $this->belongsTo(ReturnedPiece::class);
    }
}
