<?php

namespace App\Models;

use App\Enums\ReturnPieceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReturnedPiece extends Model
{
    /** @use HasFactory<\Database\Factories\ReturnedPieceFactory> */
    use HasFactory;
    protected $fillable = [
        'return_id',
        'quantity',
        'fine_per_piece',
        'status',
    ];
    protected $casts = [
        'fine_per_piece' => 'decimal:2',
        'status' => ReturnPieceStatus::class,
    ];
    public function returnRecord(): BelongsTo
    {
        return $this->belongsTo(ReturnRecord::class);
    }
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }
}
