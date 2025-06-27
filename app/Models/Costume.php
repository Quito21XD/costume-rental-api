<?php

namespace App\Models;

use App\Enums\CostumeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Costume extends Api
{
    /** @use HasFactory<\Database\Factories\CostumeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'gender',
        'rental_price',
        'size',
        'status',
    ];

    protected $casts = [
        'rental_price' => 'decimal:2',
        'status' => CostumeStatus::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function pieces(): BelongsToMany
    {
        return $this->belongsToMany(Piece::class)->withTimestamps();
    }

    public function costumeRentals(): HasMany
    {
        return $this->hasMany(RentalDetail::class);
    }
}
