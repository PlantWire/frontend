<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(HumiditySensor::class, function (Faker $faker) {
    return [
        'uuid' => "4df992ed-12eb-4e11-a428-4d6dd3f43f2d",
        'name' => $faker->word,
        'alarm_threshold' => $faker->randomDigitNotNull,
        'note' => $faker->sentence,
        'measurement_start' => Carbon($faker->dateTime($max = 'now', $timezone = null)),
        'measurement_interval' => CarbonInterval::hours($faker->numberBetween($min = 1, $max = 24)),
    ];
});
