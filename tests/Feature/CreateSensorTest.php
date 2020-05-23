<?php

namespace Tests\Feature;
use Tests\TestCase;

class CreateSensorTest extends TestCase
{
    /** @test */
    public function createSensorRedirectsToLogin()
    {
        $response = $this->get('/humiditysensor/create');
        $response->assertRedirect('/login');
    }


    /** @test */
    public function sensorCantBeCreatedIfUserIsNotLoggedIn()
    {
        $faker = \Faker\Factory::create();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/humiditysensor', ['uuid' => $faker->uuid(), 'pin' => '1234', 'name' => 'MyTestSensor']);

        $response
            ->assertStatus(401);
    }


    /** @test */
    public function sensorCanBeCreatedIfUserIsLoggedIn()
    {
        $faker = \Faker\Factory::create();

        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/humiditysensor', ['uuid' => $faker->uuid(), 'pin' => '1234', 'name' => 'MyTestSensor']);

        $response
            ->assertStatus(302);
    }
}
