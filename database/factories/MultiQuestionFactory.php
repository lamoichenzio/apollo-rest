<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MultiQuestion;
use Faker\Generator as Faker;

$factory->define(MultiQuestion::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'position' => $faker->numberBetween(0, 10),
        'mandatory' => $faker->boolean,
        'type' => $faker->randomElement(\App\Enums\MultiQuestionTypes::types()),
        'other' => $faker->boolean,
        'question_group_id' => factory(\App\QuestionGroup::class)
    ];
});
