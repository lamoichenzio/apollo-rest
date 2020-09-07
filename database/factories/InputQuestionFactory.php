<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InputQuestion;
use Faker\Generator as Faker;

$factory->define(InputQuestion::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'description' => $faker->paragraph,
        'mandatory' => $faker->boolean,
        'position' => $faker->numberBetween(0, 10),
        'type' => $faker->randomElement(\App\Enums\InputQuestionType::types()),
        'question_group_id' => factory(\App\QuestionGroup::class)
    ];
});
