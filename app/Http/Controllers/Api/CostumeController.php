<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCostumeRequest;
use App\Http\Requests\UpdateCostumeRequest;
use App\Http\Resources\CostumeResource;
use App\Models\Costume;
use App\Services\CostumeService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class CostumeController extends Controller // implements HasMiddleware
{
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('auth:api', except: ['index', 'show']),
    //     ];
    // }
    public function __construct(
        private CostumeService $costumeService
    ) {}

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

        $costume = $this->costumeService->costumeCreate($data);

        return CostumeResource::make($costume)->response()->setStatusCode(201);
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
    public function update(UpdateCostumeRequest $request, Costume $costume)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($costume->image_path) {
                Storage::delete($costume->image_path);
            }
            $data['image_path'] = Storage::put('costumes', $request->file('image'));
        }
        $costume = $this->costumeService->costumeUpdate($costume, $data);

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
