<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MultiAnswer;
use Faker\Generator as Faker;

$factory->define(MultiAnswer::class, function (Faker $faker) {
    return [
        'multi_question_id' => factory(\App\MultiQuestion::class),
        'survey_answer_id' => factory(\App\SurveyAnswer::class),
    ];
});
