<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MatrixQuestion;
use Faker\Generator as Faker;

$factory->define(MatrixQuestion::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'description' => $faker->text,
        'position' => $faker->numberBetween(0, 10),
        'mandatory' => $faker->boolean,
        'type' => $faker->randomElement(\App\Enums\MatrixQuestionTypes::types()),
        'question_group_id' => factory(\App\QuestionGroup::class)
    ];
});
