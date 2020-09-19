<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SingleMatrixAnswer;
use Faker\Generator as Faker;

$factory->define(SingleMatrixAnswer::class, function (Faker $faker) {
    return [
        'matrix_question_id' => factory(\App\MatrixQuestion::class),

    ];
});
