<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PieceResource;
use App\Models\Piece;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pieces = Piece::getOrPaginate();
        return PieceResource::collection($pieces);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'replacement_cost' => 'required|decimal:0,2|min:0',
            'material' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'piece_type_id' => 'required|exists:piece_types,id',
            'size_id' => 'required|exists:sizes,id',
        ]);
        $piece = Piece::create($data);
        return PieceResource::make($piece);
    }

    /**
     * Display the specified resource.
     */
    public function show(Piece $piece)
    {
        return PieceResource::make($piece);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Piece $piece)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'replacement_cost' => 'required|decimal:0,2|min:0',
            'material' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'piece_type_id' => 'required|exists:piece_types,id',
            'size_id' => 'required|exists:sizes,id',
        ]);
        $piece->update($data);
        return PieceResource::make($piece);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Piece $piece)
    {
        $piece->delete();
        return response()->noContent();
    }
}
