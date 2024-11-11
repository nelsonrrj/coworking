<?php

namespace App\DataValues;

class ReservationStatus
{
    public const PENDING = 1;
    public const APPROVED = 2;
    public const REJECTED = 3;

    public static function getAll(): array
    {
        return [
            self::PENDING,
            self::APPROVED,
            self::REJECTED,
        ];
    }
}
