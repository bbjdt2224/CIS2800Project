<?php

use Faker\Generator as Faker;

$factory->define(App\Header::class, function (Faker $faker) {
    return [
        'userId' => $faker->randomDigitNotNull,
        'header' => $faker->randomElement($array = array ('Fund & Cost Center: 11-0024680','Job Code: 060049')),
    ];
});
