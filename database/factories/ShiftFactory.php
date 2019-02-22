<?php

use Faker\Generator as Faker;

$factory->define(App\Shift::class, function (Faker $faker) {
    return [
        'date' => $faker->date($format = '2019-m-d', $max = 'now'),
        'start' => $faker->date($format = 'g:i', $max = 'now'),
        'end' => $faker->date($format = 'g:i', $max = 'now'),
        'timesheetId' => function() {
            return factory(App\Timesheet::class)->create()->id;
        },
        'description' => ' ',
        'total' => $faker->randomDigitNotNull,
    ];
});
