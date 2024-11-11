<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(private readonly ReservationService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->service->getCostumerReservations(
            $request->user()->id,
            $request->get('page', 0),
            $request->get('perPage', 15)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request): JsonResponse
    {
        return $this->service->create($request->user()->id, $request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
