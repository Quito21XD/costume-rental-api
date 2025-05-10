<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Piece extends Api
{
    /** @use HasFactory<\Database\Factories\PieceFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'replacement_cost',
        'material',
        'color',
        'piece_type_id',
        'size_id',
    ];
    protected $casts = [
        'replacement_cost' => 'decimal:2',
    ];
    public function costumes(): BelongsToMany
    {
        return $this->belongsToMany(Costume::class)->withPivot('stock', 'status');
    }
    public function pieceType(): BelongsTo
    {
        return $this->belongsTo(PieceType::class);
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }
}
