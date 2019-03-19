<?php

use Faker\Generator as Faker;

$factory->define(App\Organization::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement($array = array ('Student Success Center','Valley Dining Center', 'Western Heights', 'Eldridge/Fox', 'Harrison/Stinson', 'Burnham Dining Hall', 'Bistro', 'First Year Expierence')),
        'members' => $faker->randomDigitNotNull
    ];
});
