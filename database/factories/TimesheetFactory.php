<?php

use Faker\Generator as Faker;

$factory->define(App\Timesheet::class, function (Faker $faker) {

    $date = $faker->randomDigitNotNull;
    if ($date > 52){
        $date = 3;
    }
    if($date%2 != 1){
        $date = $date -1;
    }
    $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));
	
    return [
        'userId' => function(){
        	return factory(App\User::class)->create()->id;
        },
        'startDate' => $date,
        'total' => $faker->randomDigitNotNull,
        'status' => $faker->randomElement($array = array ('approved','submitted', 'progress', 'rejected')),
    ];
});
