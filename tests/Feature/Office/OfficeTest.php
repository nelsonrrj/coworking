<?php

namespace Tests\Feature\Office;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class OfficeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_get_status_200_from_get_office_api(): void
    {
        $response = $this->get('/offices');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_validate_office_information_to_save(): void
    {
        $officeInformation = [
            'name' => '',
            'description' => ''
        ];

        $response = $this->post('/offices', $officeInformation);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_save_office_information_in_database(): void
    {
        $officeInformation = [
            'name' => 'new office' . $this->faker->unixTime(),
            'description' => 'some description'
        ];

        $response = $this->post('/offices', $officeInformation);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas(
            'offices',
            ['name' => $officeInformation['name']]
        );
    }
}
