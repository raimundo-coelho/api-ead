<?php

use Faker\Generator as Faker;

$factory->define(IDEALE\Models\Manager::class, function (Faker $faker) {
    return [
        'feedback' => $faker->sentence,
        'evaluation' => 5,
        'done' => 0,
        'user_id' => 1,
        'course_id' => 1,
//        'date_due' => 1,
    ];
});