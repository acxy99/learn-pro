<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Topic;
use Faker\Generator as Faker;

$factory->define(Topic::class, function (Faker $faker) {
    return [
        //
        'title'=> $faker->sentence(1),
        'custom_index'=> $faker->numberBetween(1,20),
        'difficulity'=>'easy',
        'course_id' =>1,

    ];
});
