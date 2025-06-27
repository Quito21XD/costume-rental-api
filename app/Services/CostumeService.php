<?php

namespace App\Services;

use App\Enums\PieceStockStatus;
use App\Http\Requests\StorePieceRequest;
use App\Models\Costume;
use App\Models\Piece;
use App\Models\PieceStock;
use Illuminate\Support\Facades\Validator;

class CostumeService
{
    public function costumeCreate(array $data): Costume
    {
        $costume = Costume::create($data)->fresh();

        $costume->categories()->sync($data['categories']);
        // Get the IDs of the pieces
        foreach ($data['pieces'] as $pieceData) {
            if (empty($pieceData['id'])) {
                $piece = Piece::create([
                    'type' => $pieceData['type'],
                    'replacement_cost' => $pieceData['replacement_cost'],
                    'material' => $pieceData['material'],
                    'color' => $pieceData['color'],
                    'size' => $pieceData['size'],
                    'details' => $pieceData['details'] ?? null,
                ]);
                $pieceData['id'] = $piece->id;
            }
            PieceStock::updateOrCreate(
                [
                    'piece_id' => $pieceData['id'],
                    'status' => PieceStockStatus::AVAILABLE->value,
                ],
                ['stock' => $pieceData['stock']]
            );
            $pieceIds[] = $pieceData['id'];
        }
        $costume->pieces()->sync($pieceIds);
        return $costume;
    }

    public function costumeUpdate(Costume $costume, array $data): Costume
    {
        $costume->update($data);
        $costume->categories()->sync($data['categories']);
        $pieceIds = collect($data['pieces'])->pluck('id')->toArray(); // Get the IDs of the pieces
        $costume->pieces()->sync($pieceIds);
        foreach ($data['pieces'] as $pieceData) {
            PieceStock::updateOrCreate(
                [
                    'piece_id' => $pieceData['id'],
                    'status' => PieceStockStatus::AVAILABLE->value,
                ],
                ['stock' => $pieceData['stock']]
            );
        }

        return $costume;
    }
}
