<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvitationEmails;
use Faker\Generator as Faker;

$factory->define(InvitationEmails::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'invitation_pool_id' => factory(App\InvitationPool::class)
    ];
});
