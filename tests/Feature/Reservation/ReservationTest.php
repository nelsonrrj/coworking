<?php

namespace Tests\Feature;

use App\DataValues\ReservationStatus;
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

    public function test_customer_get_all_his_reservations(): void
    {
        $userReservations = 5;
        $user = User::factory()->notAdmin()->create();
        Reservation::factory()
            ->count($userReservations)
            ->create(['user_id' => $user['id']]);

        $this->actingAs($user);

        $response = $this->get('/reservations');

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($userReservations, 'data.data');
    }

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

    public function test_admin_user_approved_a_reservation()
    {
        $admin = User::factory()->admin()->create();
        $reservation = Reservation::factory()->create();

        $this->actingAs($admin);
        $response = $this->put("/reservations/{$reservation['id']}", ['reservation_status' => ReservationStatus::APPROVED]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(
            'reservations',
            [
                'id' => $reservation['id'],
                'reservation_status' => ReservationStatus::APPROVED
            ]
        );
    }

    public function test_costumer_cannot_approved_a_reservation()
    {
        $user = User::factory()->notAdmin()->create();
        $reservation = Reservation::factory()->create();

        $this->actingAs($user);
        $response = $this->put("/reservations/{$reservation['id']}", ['reservation_status' => ReservationStatus::APPROVED]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
