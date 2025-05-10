<?php

namespace App\Http\Controllers\Api;

use App\Enums\CostumeStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCostumeRequest;
use App\Http\Resources\CostumeResource;
use App\Models\Costume;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class CostumeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index', 'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costumes = Costume::getOrPaginate();
        return CostumeResource::collection($costumes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCostumeRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image_path'] = Storage::put('costumes', $request->file('image'));
        }
        $costume = Costume::create($data);

        $costume->categories()->sync($data['categories']);

        $pieces = [];
        foreach ($data['pieces'] as $pieceData) {
            $piece = Piece::create($pieceData);
            $pieces[$piece->id] = [
                'stock' => $pieceData['stock'],
                'status' => $pieceData['status'],
            ];
        }
        $costume->pieces()->sync($pieces);

        return CostumeResource::make($costume);
    }

    /**
     * Display the specified resource.
     */
    public function show(Costume $costume)
    {
        return CostumeResource::make($costume);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Costume $costume)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable|text',
            'image' => 'nullable|image',
            'gender' => 'required|string',
            'rental_price' => 'required|numeric|min:0',
            'status' => ['required', Rule::enum(CostumeStatus::class)],
            'categories' => 'required|array', // no es obligatorio, puede venir vacío
            'categories.*' => 'exists:categories,id', //validación para cada id de categoría
        ]);
        if ($request->hasFile('image')) {
            if ($costume->image_path) {
                Storage::delete($costume->image_path);
            }
            $data['image_path'] = Storage::put('costumes', $request->file('image'));
        }
        $costume->update($data);

        if (isset($data['categories'])) {
            $costume->categories()->sync($data['categories']);
        }

        return CostumeResource::make($costume);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Costume $costume)
    {
        $costume->delete();
        return response()->noContent();
    }
}
