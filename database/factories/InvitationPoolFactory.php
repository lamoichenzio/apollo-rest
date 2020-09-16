<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvitationPool;
use Faker\Generator as Faker;

$factory->define(InvitationPool::class, function (Faker $faker) {
    return [
        'password' => $faker->password,
        'survey_id' => factory(\App\Survey::class)
    ];
});
