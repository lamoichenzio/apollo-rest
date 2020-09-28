<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MatrixQuestionElement;
use Faker\Generator as Faker;

$factory->define(MatrixQuestionElement::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'matrix_question_id' => factory(\App\MatrixQuestion::class)
    ];
});
