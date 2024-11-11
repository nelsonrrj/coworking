<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class ReservationService extends ApiService
{
    public function __construct(private readonly ReservationRepository $reservationRepo) {}

    public function create(int $userId, array $reservationData): JsonResponse
    {
        $endAt = now()
            ->setDateTimeFrom($reservationData['start_at'])
            ->addMinutes(config('reservation.duration_in_minutes'));

        $result = $this->reservationRepo
            ->create([
                'user_id' => $userId,
                'end_at' => $endAt,
                ...$reservationData
            ]);

        return $this->jsonResponse($result, Response::HTTP_CREATED);
    }
}
