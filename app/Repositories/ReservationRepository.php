<?php

namespace App\Repositories;

use App\Models\Reservation;

final class ReservationRepository
{
    public function __construct(private readonly Reservation $model) {}

    public function create(array $reservationData): array
    {
        $reservation = $this->model->newInstance($reservationData);
        $reservation->save();

        return $reservation->toArray();
    }
}
