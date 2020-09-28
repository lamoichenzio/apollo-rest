<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\QuestionGroup;
use Faker\Generator as Faker;

$factory->define(QuestionGroup::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'survey_id' => factory(\App\Survey::class)
    ];
});
