<?php

use Faker\Generator as Faker;

$factory->define(IDEALE\Models\Reply::class, function (Faker $faker) {
    return [
        'body' => implode(' ', $faker->paragraphs),
        'user_id' => 1,
        'thread_id' => rand(1, 50),
    ];
});
