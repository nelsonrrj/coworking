<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_access_to_get_reservations_api(): void
    {
        $user = User::factory()->notAdmin()->create();

        $this->actingAs($user);

        $response = $this->get('/reservations');

        $response->assertStatus(Response::HTTP_OK);
    }

    //TODO: list reservations

    public function test_customer_send_incomplete_data_to_create_reservation_api(): void
    {
        $user = User::factory()->notAdmin()->create();

        $reservationData = [
            'office_id' => '',
            'start_at' => '',
        ];

        $this->actingAs($user);

        $response = $this->post('/reservations', $reservationData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_customer_send_complete_data_to_create_reservation_api(): void
    {
        $this->refreshDatabase();

        $user = User::factory()->notAdmin()->create();
        $office = Office::factory()->create();

        $startAt = now();

        $reservationData = [
            'office_id' => $office['id'],
            'start_at' => $startAt,
        ];

        $this->actingAs($user);

        $response = $this->post('/reservations', $reservationData);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user['id'],
            'office_id' => $office['id'],
            'start_at' => $startAt->toDateTimeString(),
        ]);
    }

    public function test_create_reservation_with_duration_configured(): void
    {
        $this->refreshDatabase();

        $user = User::factory()->notAdmin()->create();
        $office = Office::factory()->create();

        $startAt = now();
        $endAt = now()->addMinutes(config('reservation.duration_in_minutes'));

        $reservationData = [
            'office_id' => $office['id'],
            'start_at' => $startAt,
        ];

        $this->actingAs($user);

        $response = $this->post('/reservations', $reservationData);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user['id'],
            'office_id' => $office['id'],
            'start_at' => $startAt->toDateTimeString(),
            'end_at' => $endAt->toDateTimeString()
        ]);
    }

    public function test_error_trying_to_create_a_reservation_in_a_occupied_spot(): void
    {
        $user = User::factory()->notAdmin()->create();
        $office = Office::factory()->create();
        $startAt = now();

        // old reservation
        Reservation::factory()->create([
            'start_at' => now()->addMinutes(15),
        ]);

        $newReservationData = [
            'office_id' => $office['id'],
            'start_at' => $startAt,
        ];

        $this->actingAs($user);

        $response = $this->post('/reservations', $newReservationData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
