<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'date' => $faker->dateTime($max = 'now', $timezone = null),
        'start_time' => $faker->dateTime($max = 'now', $timezone = null),
        'end_time' => $faker->dateTime($max = 'now', $timezone = null),
        'location' => $faker->address(),
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'fee' => true,
        'fee_amount' => $faker->numberBetween($min = 1000, $max = 9000)
    ];
});
