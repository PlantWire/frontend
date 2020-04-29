<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(HumidityMeasurement::class, function (Faker $faker) {
    return [
        'value' => $faker->numberBetween($min = 100, $max = 1700) ,
        'sensor' => HumiditySensor::All()->random(),
    ];
});
