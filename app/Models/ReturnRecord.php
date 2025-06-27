<?php

namespace App\Models;

use App\Enums\ReturnRecordStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReturnRecord extends Api
{
    /** @use HasFactory<\Database\Factories\ReturnRecordFactory> */
    use HasFactory;

    protected $table = 'return_records';

    protected $fillable = [
        'rental_id',
        'user_id',
        'actual_return_date',
        'late_fee',
        'status',
    ];

    protected $casts = [
        'late_fee' => 'decimal:2',
        'status' => ReturnRecordStatus::class,
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function returnedPieces(): HasMany
    {
        return $this->HasMany(ReturnedPiece::class, 'returned_pieces');
    }
}
