<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SurveyAnswer;
use Faker\Generator as Faker;

$factory->define(SurveyAnswer::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'totAnswers' => $faker->numberBetween(1, 10),
        'survey_id' => factory(\App\Survey::class)
    ];
});
