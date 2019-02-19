<?php

use Faker\Generator as Faker;

$factory->define(App\Timesheets::class, function (Faker $faker) {
	
    return [
        'userId' => function(){
        	return factory(App\User::class)->create()->id;
        },
        'startDate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'total' => $faker->randomDigitNotNull,
        'submitted' => $faker->randomElement($array = array ('0','1')),
    ];
});
