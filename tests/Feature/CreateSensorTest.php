<?php

namespace Tests\Feature;
use Tests\TestCase;

class CreateSensorTest extends TestCase
{
    /** @test */
    public function createSensorRedirectsToLogin()
    {
        $response = $this->get('/create_sensor');
        $response->assertRedirect('/login');
    }


    /** @test */
    public function sensorCantBeCreatedIfUserIsNotLoggedIn()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/store_sensor', ['uuid' => '1234-1234-1234-1234', 'pin' => '1234', 'name' => 'My Test-Sensor']);

        $response
            ->assertStatus(401);
    }
}
