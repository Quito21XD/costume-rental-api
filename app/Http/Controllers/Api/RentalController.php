<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentalRequest;
use App\Http\Resources\RentalResource;
use App\Models\Rental;
use App\Services\RentalService;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function __construct(
        private RentalService $rentalService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = Rental::GetOrPaginate();

        return RentalResource::collection($rentals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentalRequest $request)
    {
        $data = $request->validated();

        $rental = $this->rentalService->rentalCreate($data);

        return RentalResource::make($rental);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        return RentalResource::make($rental);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        // no se usara el update en Rentals
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();

        return response()->noContent();
    }
}
