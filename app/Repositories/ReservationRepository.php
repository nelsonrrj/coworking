<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Support\Facades\Date;

final class ReservationRepository
{
    public function __construct(private readonly Reservation $model) {}

    public function create(array $reservationData): array
    {
        $reservation = $this->model->newInstance($reservationData);
        $reservation->save();

        return $reservation->toArray();
    }

    public static function isAvailableDate(string $startDate, int $officeId): bool
    {
        $endDate = Date::createFromDate($startDate)->addMinutes(
            config('reservation.duration_in_minutes')
        );

        $result = Reservation::where('office_id', '=', $officeId)
            ->whereBetween('start_at', [$startDate, $endDate])
            ->orWhereBetween('end_at', [$startDate, $endDate])
            ->get();

        return $result->isEmpty();
    }

    public function getReservationByCostumer(int $userId, int $page, int $perPage): array
    {
        $result = $this->model->newQuery()
            ->where('user_id', '=', $userId)
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $total = $this->model->newQuery()->count();

        return ['data' => $result, 'total' => $total];
    }
}
