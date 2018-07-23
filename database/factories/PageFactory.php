<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {
    $sentence = $faker->sentence;
    $title = substr($sentence, 0, strlen($sentence) - 1);

    return [
        'title' => $title,
        'body' => $faker->paragraphs($nb = 3, $asText = true) ,
        'course_id' => factory('App\Course')->create(),
    ];
});
