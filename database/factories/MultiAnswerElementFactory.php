<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MultiAnswerElement;
use Faker\Generator as Faker;

$factory->define(MultiAnswerElement::class, function (Faker $faker) {
    return [
        'answer' => $faker->word,
        'answer_group_id' => factory(\App\MultiAnswer::class),
        'answer_group_type' => \App\MultiAnswer::class
    ];
});
