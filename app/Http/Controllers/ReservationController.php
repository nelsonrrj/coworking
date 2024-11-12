<?php

namespace App\Http\Controllers;

use App\DataValues\ReservationFilterDto;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
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
            $request->get('page', 1),
            $request->get('perPage', 15)
        );
    }

    public function listByAdmin(Request $request)
    {
        return $this->service->getAdminReservations(
            page: $request->get('page', 1),
            perPage: $request->get('perPage', 15),
            officeId: $request->get('office')
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
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, string $reservationId): JsonResponse
    {
        return $this->service->updateStatus(
            $reservationId,
            $request->get('reservation_status'),
        );
    }
}
