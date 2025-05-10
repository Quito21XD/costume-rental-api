<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PieceType extends Model
{
    /** @use HasFactory<\Database\Factories\PieceTypeFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function pieces(): HasMany
    {
        return $this->hasMany(Piece::class);
    }
    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }
}
