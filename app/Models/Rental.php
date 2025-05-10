<?php

namespace App\Models;

use App\Enums\RentalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory;
    protected $fillable = [
        'warranty_value',
        'rental_date',
        'return_date',
        'status',
        'user_id',
        'customer_id'
    ];
    protected $casts = [
        'status' => RentalStatus::class,
    ];
    public function costumes(): BelongsToMany
    {
        return $this->belongsToMany(Costume::class)->withPivot('rental_price', 'quantity', 'notes');
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function returnRecord(): HasOne
    {
        return $this->hasOne(ReturnRecord::class);
    }
}
