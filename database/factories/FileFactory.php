<?php

use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(App\File::class, function (Faker $faker) {
    return [
        'name' => UploadedFile::fake()->create($faker->word() . '.pdf')->name,
        'course_id' => factory('App\Course')->create(),
    ];
});
