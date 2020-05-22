<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Carbon;
use HumiditySensorsTableSeeder;

class ChangeSensorTest extends TestCase
{

    /** @test */
    public function changeSensorAccessible()
    {
        $this->seed(HumiditySensorsTableSeeder::class);

        $response = $this->get('/humiditysensor/1/edit');
        $response->assertStatus(200);
    }

    /** @test */
    public function changeSensorAccessibleIfLoggedIn()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->get('/humiditysensor/1/edit');
        $response->assertStatus(200);
    }

    /** @test */
    public function changeSensorCannotBeOverwrittenIfNotLoggedIn()
    {
        $this->seed(HumiditySensorsTableSeeder::class);

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'notes' => 'I\'m some notes.', 'measurement_interval_days' => 1, 'measurement_interval_hours' => 12,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(401);
    }

    /** @test */
    public function changeSensorCanBeOverwrittenIfLoggedIn()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'notes' => 'I\'m some notes.', 'measurement_interval_days' => 1, 'measurement_interval_hours' => 12,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(302);
    }

    /** @test */
    public function changeSensorRequiresSensorName()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['alarm_threshold' => 22, 'notes' => 'I\'m some notes.',
            'measurement_interval_days' => 1, 'measurement_interval_hours' => 12,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(422);
        //    ->assertSessionHas(['name' => 'The Sensor Name field is required.']);
    }

    /** @test */
    public function alarmThresholdForChangeSensor()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'notes' => 'I\'m some notes.',
            'measurement_interval_days' => 1, 'measurement_interval_hours' => 12,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(302);
    }

    /** @test */
    public function notesIsOptionalForChangeSensor()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'measurement_interval_days' => 1, 'measurement_interval_hours' => 12,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(302);
    }

    /** @test */
    public function measurementIntervalDaysIsOptionalForChangeSensor()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'notes' => 'I\'m some notes.', 'measurement_interval_hours' => 12,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(302);
    }

    /** @test */
    public function measurementIntervalHoursIsOptionalForChangeSensor()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'notes' => 'I\'m some notes.', 'measurement_interval_days' => 12,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(302);
    }

    /** @test */
    public function  changeSensorRequiresEitherMeasurementIntervalDaysOrMeasurementIntervalHours()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'notes' => 'I\'m some notes.', 'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(422);
        //    ->assertSessionHas(['name' => 'Measurement Interval days and Measurement Interval hours cannot both be empty or 0.']);
    }

    /** @test */
    public function  changeSensorRequiresEitherMeasurementIntervalDaysOrMeasurementIntervalHoursToBeAboveZero()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'notes' => 'I\'m some notes.', 'measurement_interval_days' => 0, 'measurement_interval_hours' => 0,
            'measurement_start' => Carbon\Carbon::now()->addDays(1)]);

        $response->assertStatus(422);
        //    ->assertSessionHas(['name' => 'Measurement Interval days and Measurement Interval hours cannot both be empty or 0.']);
    }

    /** @test */
    public function measurementStartIsOptionalForChangeSensor()
    {
        $this->seed(HumiditySensorsTableSeeder::class);
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PATCH', '/humiditysensor/1', ['sensor_name' => 'Erdbeeren', 'alarm_threshold' => 22,
            'notes' => 'I\'m some notes.', 'measurement_interval_days' => 12,
            'measurement_interval_hours' => 12]);

        $response->assertStatus(302);
    }
}
