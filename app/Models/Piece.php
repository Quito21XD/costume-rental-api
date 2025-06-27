<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Piece extends Api
{
    /** @use HasFactory<\Database\Factories\PieceFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'replacement_cost',
        'material',
        'color',
        'size',
    ];

    protected $casts = [
        'replacement_cost' => 'decimal:2',
    ];

    public function pieceStocks(): HasMany
    {
        return $this->hasMany(PieceStock::class);
    }

    public function pieceType(): BelongsTo
    {
        return $this->belongsTo(PieceType::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function costumes(): BelongsToMany
    {
        return $this->belongsToMany(Costume::class)->withTimestamps();
    }

    public function rentalDetails(): BelongsToMany
    {
        return $this->belongsToMany(RentalDetail::class, 'rented_pieces')
            ->withPivot('piece_quantity')
            ->withTimestamps();
    }

    public function returnedPieces(): HasMany
    {
        return $this->HasMany(ReturnedPiece::class, 'returned_pieces');
    }
}
