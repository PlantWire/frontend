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
        ])->json('POST', '/store_sensor', ['uuid' => '550e8400-e29b-11d4-a716-446655440000', 'pin' => '1234', 'name' => 'MyTestSensor']);

        $response
            ->assertStatus(401);
    }


    /** @test */
    public function sensorCanBeCreatedIfUserIsLoggedIn()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/store_sensor', ['uuid' => '550e8400-e29b-11d4-a716-446655440000', 'pin' => '1234', 'name' => 'MyTestSensor']);

        $response
            ->assertStatus(302);
    }
}
