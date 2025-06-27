<?php

namespace App\Models;

use App\Enums\ReturnPieceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnedPiece extends Api
{
    /** @use HasFactory<\Database\Factories\ReturnedPieceFactory> */
    use HasFactory;

    protected $fillable = [
        'return_record_id',
        'piece_id',
        'quantity',
        'damage_fee',
        'piece_status',
    ];

    protected $casts = [
        'damage_fee' => 'decimal:2',
        'piece_status' => ReturnPieceStatus::class,
    ];

    public function returnRecord(): BelongsTo
    {
        return $this->belongsTo(ReturnRecord::class);
    }

    public function piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class);
    }
}
