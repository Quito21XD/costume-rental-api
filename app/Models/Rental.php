<?php

namespace App\Models;

use App\Enums\RentalStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Api
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory;

    protected $fillable = [
        'warranty_value',
        'rental_date',
        'return_date',
        'status',
        'user_id',
        'customer_id',
    ];

    protected $casts = [
        // 'return_date' => Carbon::class,
        'status' => RentalStatus::class,
    ];

    public function rentalDetails(): HasMany
    {
        return $this->hasMany(RentalDetail::class);
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

    public function lateFee(Carbon $actualReturnDate): float
    {
        $returnDate = Carbon::parse($this->return_date);
        $daysLate = $returnDate->diffInDays($actualReturnDate, false);
        $daysLate = max(0, $daysLate);
        $costumeRentals = $this->rentalDetails;
        $lateFee = 0;
        foreach ($costumeRentals as $costumeRental) {
            $rentalPrice = $costumeRental->rental_cost;
            $quantity = $costumeRental->quantity;
            $lateFee += $rentalPrice * $quantity;
        }
        $lateFee *= $daysLate;

        return $lateFee;
    }
}
