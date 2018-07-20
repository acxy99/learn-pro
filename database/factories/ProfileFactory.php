<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'first_name' => $faker->firstName, 
        'last_name' => $faker->lastName,
    ];
});
