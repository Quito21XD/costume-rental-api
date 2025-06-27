<?php

namespace App\Services;

use App\Enums\RentalStatus;
use App\Enums\ReturnPieceStatus;
use App\Models\Piece;
use App\Models\Rental;
use App\Models\ReturnedPiece;
use App\Models\ReturnRecord;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReturnRecordService
{
    /**
     * Crea un registro de devolución.
     *
     * @throws ValidationException
     */
    public function returnRecordCreate(array $data): ReturnRecord
    {
        try {
            $rental = Rental::findOrFail($data['rental_id']);
        } catch (ModelNotFoundException $e) {
            throw new ValidationException('Rental not found.');
        }
        $data['user_id'] = auth('api')->id();
        $data['actual_return_date'] = now()->startOfDay();
        $data['late_fee'] = $rental->lateFee($data['actual_return_date']);
        $returnRecord = ReturnRecord::create($data);
        $rental->update(['status' => RentalStatus::COMPLETED]);
        $this->returnPiecesUpdateOrCreate($rental, $returnRecord, $data);

        return $returnRecord;
    }

    public function returnRecordUpdate(array $data): ReturnRecord
    {
        try {
            $rental = Rental::findOrFail($data['rental_id']);
        } catch (ModelNotFoundException $e) {
            throw new ValidationException('Rental not found.');
        }
        $data['user_id'] = auth('api')->id();
        $returnRecord = $rental->returnRecord;
        $returnRecord->update([
            'user_id' => $data['user_id'],
            'status' => $data['status'],
        ]);

        $this->returnPiecesUpdateOrCreate($rental, $returnRecord, $data);

        return $returnRecord;
    }

    private function damageFee($pieceId, $damageStatus)
    {
        $minorDamageFee = 0.25;
        $moderateDamageFee = 0.5;
        $replacementCost = Piece::where('id', $pieceId)->value('replacement_cost');
        if ($damageStatus == ReturnPieceStatus::MINOR_DAMAGE->value) {
            $replacementCost *= $minorDamageFee;
        } elseif ($damageStatus == ReturnPieceStatus::MODERATE_DAMAGE->value) {
            $replacementCost *= $moderateDamageFee;
        }

        return $replacementCost;
    }

    private function returnPiecesUpdateOrCreate($rental, $returnRecord, $data)
    {
        $rentalPieces = $rental->rentalDetails()->with('pieceRentals')->get();

        foreach ($rentalPieces as $costumeRental) {
            foreach ($costumeRental->pieceRentals as $piece) {
                $damagePieces = Collect($data['pieces'])->where('id', $piece->id);
                $totalGoodPieces = $piece->pivot->piece_quantity;
                if ($damagePieces->isNotEmpty()) {
                    foreach ($damagePieces as $damagePiece) {
                        if ($totalGoodPieces > 0) {
                            $quantity = min($totalGoodPieces, $damagePiece['quantity']);
                            $damageFee = $this->damageFee($damagePiece['id'], $damagePiece['piece_status']);
                            ReturnedPiece::updateOrCreate(
                                [
                                    'return_record_id' => $returnRecord->id,
                                    'piece_id' => $damagePiece['id'],
                                    'piece_status' => $damagePiece['piece_status'],
                                ],
                                [
                                    'quantity' => $quantity,
                                    'damage_fee' => $damageFee,
                                ]
                            );
                            $totalGoodPieces -= $quantity;
                        }
                    }
                }
                if ($totalGoodPieces > 0) {
                    ReturnedPiece::updateOrCreate(
                        [
                            'return_record_id' => $returnRecord->id,
                            'piece_id' => $piece->id,
                            'piece_status' => ReturnPieceStatus::GOOD->value,
                        ],
                        [
                            'quantity' => $totalGoodPieces,
                            'damage_fee' => 0,

                        ]
                    );
                }
            }
        }
    }
}
