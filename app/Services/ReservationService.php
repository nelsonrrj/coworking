<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;

final class ReservationService extends ApiService
{
    public function __construct(private readonly ReservationRepository $reservationRepo) {}

    public function create(int $userId, array $reservationData): JsonResponse
    {
        $endAt = Date::createFromDate($reservationData['start_at'])
            ->addMinutes(config('reservation.duration_in_minutes'));

        $result = $this->reservationRepo
            ->create([
                ...$reservationData,
                'user_id' => $userId,
                'end_at' => $endAt,
            ]);

        return $this->jsonResponse($result, Response::HTTP_CREATED);
    }

    public function getCostumerReservations(int $userId, int $page, int $perPage): JsonResponse
    {
        $result = $this->reservationRepo->getReservationByCostumer($userId, $page, $perPage);

        return $this->jsonResponse($result);
    }

    public function updateStatus(int $reservationId, int $reservationStatus): JsonResponse
    {
        $this->reservationRepo->update($reservationId, ['reservation_status' => $reservationStatus]);

        return $this->jsonResponse();
    }

    public function getAdminReservations(int $page, int $perPage, int|null $officeId = null): JsonResponse
    {
        $result = $this->reservationRepo->getListFilter($page, $perPage, $officeId);
        return $this->jsonResponse($result);
    }
}
