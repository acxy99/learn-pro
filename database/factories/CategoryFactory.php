<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    $sentence = $faker->sentence;
    $title = substr($sentence, 0, strlen($sentence) - 1);

    return [
        'title' => $title,
        'description' => $faker->text,
    ];
});
