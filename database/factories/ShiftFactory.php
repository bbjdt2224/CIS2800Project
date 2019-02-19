<?php

use Faker\Generator as Faker;

$factory->define(App\Shift::class, function (Faker $faker) {
    return [
        'start' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'end' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'timesheetId' => function() {
            return factory(App\Timesheet::class)->create()->id;
        },
        'description' => ' ',
        'total' => $faker->randomDigitNotNull,
    ];
});
