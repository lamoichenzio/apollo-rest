<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Survey;
use Faker\Generator as Faker;

$factory->define(Survey::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'secret' => $faker->boolean,
        'active' => $faker->boolean,
        'start_date' => $faker->date(),
        'end_date' => $faker->date(),
        'url_id' => $faker->url,
        'user_id' => 1
    ];
});
