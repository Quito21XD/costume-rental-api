<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReturnRecord extends Model
{
    /** @use HasFactory<\Database\Factories\ReturnRecordFactory> */
    use HasFactory;
    protected $table = 'returns';
    protected $fillable = [
        'rental_id',
        'user_id',
        'actual_return_date',
        'fine',
    ];
    protected $casts = [
        'fine' => 'decimal:2',
    ];
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
    public function returnPieces(): HasMany
    {
        return $this->hasMany(ReturnedPiece::class);
    }
}
