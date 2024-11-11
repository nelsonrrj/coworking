<?php

namespace Database\Factories;

use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startAt = now();
        $endAt = now()->addMinutes(config('reservation.duration_in_minutes'));
        return [
            'office_id' => Office::factory(),
            'user_id' => User::factory(),
            'start_at' => $startAt,
            'end_at' => $endAt
        ];
    }
}
