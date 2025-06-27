<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RentalDetail extends Api
{
    protected $fillable = [
        'costume_id',
        'rental_id',
        'rental_price',
        'quantity',
        'notes',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function costume(): BelongsTo
    {
        return $this->belongsTo(Costume::class);
    }

    public function pieceRentals(): BelongsToMany
    {
        return $this->belongsToMany(Piece::class, 'rented_pieces')
            ->withPivot('piece_quantity')
            ->withTimestamps();
    }
}
