<?php

namespace Tests\Feature\Office;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OfficeTest extends TestCase
{
    public function test_get_status_200_from_get_office_api(): void
    {
        $response = $this->get('/offices');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_send_office_information_to_save(): void
    {
        $officeInformation = [
            'name' => 'test',
            'description' => ''
        ];

        $response = $this->post('/offices', $officeInformation);

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
}
