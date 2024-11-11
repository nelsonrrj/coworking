<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    public function test_customer_can_access_to_reservation_api(): void
    {
        $user = User::factory()->notAdmin()->create();

        $this->actingAs($user);

        $response = $this->get('/reservations');

        $response->assertStatus(Response::HTTP_OK);
    }
}
