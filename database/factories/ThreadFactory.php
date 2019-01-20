<?php

use Faker\Generator as Faker;

$factory->define(IDEALE\Models\Thread::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->sentence,
        'user_id' => '1'
    ];
});
