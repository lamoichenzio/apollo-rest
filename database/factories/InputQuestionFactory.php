<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InputQuestion;
use Faker\Generator as Faker;

$factory->define(InputQuestion::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'mandatory' => $faker->boolean,
        'position' => $faker->numberBetween(0, 10),
        'type' => $faker->randomElement(\App\Enums\InputQuestionTypes::types()),
        'question_group_id' => factory(\App\QuestionGroup::class)
    ];
});
