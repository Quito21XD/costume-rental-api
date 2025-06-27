<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReturnRecordRequest;
use App\Http\Requests\UpdateReturnRecordRequest;
use App\Http\Resources\ReturnRecordResource;
use App\Models\ReturnRecord;
use App\Services\ReturnRecordService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ReturnRecordController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index', 'show']),
        ];
    }

    public function __construct(
        private ReturnRecordService $returnRecordService
    ) {}

    public function index()
    {
        $returnRecords = ReturnRecord::GetOrPaginate();

        return ReturnRecordResource::collection($returnRecords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReturnRecordRequest $request)
    {
        $data = $request->validated();
        $returnRecord = $this->returnRecordService->returnRecordCreate($data);

        return ReturnRecordResource::make($returnRecord);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReturnRecord $returnRecord)
    {
        return ReturnRecordResource::make($returnRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReturnRecordRequest $request, ReturnRecord $returnRecord)
    {
        $data = $request->validated();
        $returnRecord = $this->returnRecordService->returnRecordUpdate($data);

        return ReturnRecordResource::make($returnRecord);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnRecord $returnRecord)
    {
        $returnRecord->delete();

        return response()->noContent();
    }
}
