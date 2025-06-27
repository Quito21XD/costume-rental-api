<?php

namespace App\Models;

use App\Enums\PieceStockStatus;

class PieceStock extends Api
{
    protected $fillable = [
        'piece_id',
        'stock',
        'status',
    ];

    protected $casts = [
        'status' => PieceStockStatus::class,
    ];

    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }
}
