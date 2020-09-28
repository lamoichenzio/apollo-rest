<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SingleAnswer;
use Faker\Generator as Faker;

$factory->define(SingleAnswer::class, function (Faker $faker) {
    return [
        'answer' => $faker->word,
        'question_id' => factory(\App\InputQuestion::class),
        'question_type' => \App\InputQuestion::class,
        'survey_answer_id' => factory(\App\SurveyAnswer::class)
    ];
});
