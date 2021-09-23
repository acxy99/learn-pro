<?php

use Faker\Generator as Faker;

$factory->define(App\Course::class, function (Faker $faker) {
    $sentence = $faker->sentence;
    $title = substr($sentence, 0, strlen($sentence) - 1);

    return [
        'code' => $faker->unique()->bothify('????####'),
        'title' => $title,
        'description' => $faker->text,
        'owner_id' => 1
    ];
});
