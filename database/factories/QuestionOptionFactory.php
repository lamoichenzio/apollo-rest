<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\QuestionOption;
use Faker\Generator as Faker;

$factory->define(QuestionOption::class, function (Faker $faker) {
    return [
        'option' => $faker->word,
        'question_id' => factory(\App\MultiQuestion::class),
        'question_type' => \App\MultiQuestion::class
    ];
});
