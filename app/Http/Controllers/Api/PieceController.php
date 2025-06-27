<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePieceRequest;
use App\Http\Requests\UpdatePieceRequest;
use App\Http\Resources\PieceResource;
use App\Models\Piece;

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
    public function store(StorePieceRequest $request)
    {
        $data = $request->validated();
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
    public function update(UpdatePieceRequest $request, Piece $piece)
    {
        $data = $request->validated();
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
