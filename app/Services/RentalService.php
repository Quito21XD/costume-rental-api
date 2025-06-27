<?php

namespace App\Services;

use App\Enums\PieceStockStatus;
use App\Models\PieceStock;
use App\Models\Rental;
use App\Models\RentalDetail;

class RentalService
{
    public function rentalCreate(array $data): Rental
    {
        $rental = Rental::create($data);
        foreach ($data['costumes'] as $costume) {
            $rentalDetails = RentalDetail::create([
                'rental_id' => $rental->id,
                'costume_id' => $costume['id'],
                'rental_price' => $costume['rental_price'],
                'quantity' => $costume['quantity'],
                'notes' => $costume['notes'],
            ]);
            $piecesQuantity = [];
            $rentalQuantity = $costume['quantity'];
            // Update the stock of the pieces
            $pieces = PieceStock::whereHas('piece', function ($query) use ($costume) {
                $query->whereHas('costumes', function ($query) use ($costume) {
                    $query->where('costume_id', $costume['id']);
                });
            })->get();
            $availablePieces = $pieces->where('status', PieceStockStatus::AVAILABLE->value);
            foreach ($availablePieces as $piece) {
                $stockAvailable = $piece->stock;
                $stockUpdate = min($stockAvailable, $rentalQuantity);
                $piece->decrement('stock', $stockUpdate);
                $stockRented = $pieces->where('status', PieceStockStatus::RENTED->value)
                    ->where('piece_id', $piece->piece_id)->first();
                if (! $stockRented) {
                    $stockRented = PieceStock::create([
                        'piece_id' => $piece->piece_id,
                        'status' => PieceStockStatus::RENTED->value,
                        'stock' => 0,
                    ]);
                }
                $stockRented->increment('stock', $stockUpdate);
                $piecesQuantity[$piece->piece_id] = [
                    'piece_quantity' => $stockUpdate,
                ];
            }
            $rentalDetails->pieceRentals()->sync($piecesQuantity);
        }

        return $rental;
    }
}
