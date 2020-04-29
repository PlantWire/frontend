<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'content' => '{type: '.$faker->randomElement($array = array ('log','measurement','error')).'}',
        'sensor' => Sensor::All()->random(),
    ];
});
